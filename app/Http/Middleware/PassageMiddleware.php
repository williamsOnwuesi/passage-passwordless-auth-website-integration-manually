<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

use Lcobucci\JWT\Encoding\CannotDecodeContent;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token\InvalidTokenStructure;
use Lcobucci\JWT\Token\Parser;
use Lcobucci\JWT\Token\UnsupportedHeaderFound;
use Lcobucci\JWT\UnencryptedToken;

// require 'vendor/autoload.php';

class PassageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if(isset($_COOKIE['psg_auth_token'])) {
            $raw_passage_auth_token = $_COOKIE['psg_auth_token'];
        }

        //$passage_auth_token = $request->cookie('psg_auth_token');


        /* ------------------------------------------------------- */
        /* Initiating lccobucci JWT parser and parsing Passage JWT */
        /* ------------------------------------------------------- */
        $parser = new Parser(new JoseEncoder());

        try {
            
            $token = $parser->parse($raw_passage_auth_token);

        } catch (CannotDecodeContent | InvalidTokenStructure | UnsupportedHeaderFound $e) {
            echo 'Oh no, an error: ' . $e->getMessage();
        }

        // assert($token instanceof UnencryptedToken);


        /* ---------------------------------------------- */
        /* Getting JWT Claims from the parsed Passage JWT */
        /* ---------------------------------------------- */
        $passage_auth_token = $token->claims()->get('sub');

        // **Notes**
        // $user = User::find($primary_key);
        // $user = User::where('input_value', 'database_value')->get();
        // **EndNotes**


        /* -------------------------------------- */
        /* Attempt to Login Passage JWT sub claim */
        /* -------------------------------------- */
        if (Auth::loginUsingId($passage_auth_token)){
            
            $request->session()->regenerate();

            return $next($request);
        }

        /* ----------------------------------------------------------------------------------------- */
        /* If Login attempt fails, Try to create a new user with the Passage JWT sub and email claim */
        /* ----------------------------------------------------------------------------------------- */
        try{

            $user_id='7zJ6TzT1dKwmlXSeyIcfhxlf';

            $url = "https://auth.passage.id/v1/apps/$user_id/currentuser/";

            $request_headers = [
                "Authorization: Bearer $raw_passage_auth_token",
            ];
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
            
            $user_data = curl_exec($ch);

            if (curl_errno($ch)) {

                //print "Error: " . curl_error($ch);
                dd(curl_error($ch));
                //exit();

            }

            // Show me the result
            curl_close($ch);
            $php_user_data = json_decode($user_data, true);

            $passage_user_email = $php_user_data["user"]["email"];

            $new_user = User::create([
                'name' => '',
                'email' => $passage_user_email,
                'password' => '',
                'psg_auth_token_sub' => $passage_auth_token,
            ]);

        }catch(Illuminate\Database\QueryException $e) {

            /* ---------------------------------------------------------------------------------------------------------------------------- */
            /* Redirect to Login page and prompt Client to Login and Enable Passage Passkey from Profile as identifier(Email) already exists*/
            /* ---------------------------------------------------------------------------------------------------------------------------- */
            return $e;

            // return redirect('/login')
            // ->withErrors(
            //     'name' => $e,
            //     'message' => 'This User already Exists in our database Please Login To Enable Passkeys from your profile.'
            // );

        }

        /* -------------------------------------------------------------------------------------------------- */
        /* If User is successfully created, Login the newly created User and proceed with the current request */
        /* -------------------------------------------------------------------------------------------------- */
        Auth::login($new_user);

        return $next($request);
    }
}
