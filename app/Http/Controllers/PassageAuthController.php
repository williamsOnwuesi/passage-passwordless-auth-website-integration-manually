<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PassageAuthController extends Controller
{
    public function AuthenticateUser (Request $request) {
        
        return redirect('/profile');

    }


    public function AddPassagePasskeysFromProfile (Request $request) {


      return view('enable_passkeys');

      //   $app_id = "vH7EbNSOWeoVp3K8N7dA1a77";
      //   $user_email = "devmicheal26@gmail.com";

      //   $url = "https://auth.passage.id/v1/apps/$app_id/register/webauthn/start";

      //   $postData = array(
      //       "identifier" => $user_email,
      //   );

      //   // for sending data as json type
      //   $fields = json_encode($postData);

      //   $ch = curl_init($url);
      //   curl_setopt($ch, CURLOPT_HTTPHEADER, 
      //       array(
      //           'Content-Type: application/json', // if the content type is json
      //       )
      //   );
      //   curl_setopt($ch, CURLOPT_HEADER, false);
      //   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      //   curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
      //   curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

      //   $result = curl_exec($ch);
      //   curl_close($ch);

      //   $parsed_json_result = json_decode($result, true) ;

      //   if (isset($parsed_json_result["code"]) && isset($parsed_json_result["error"])) {
      //       return redirect('/login')->withErrors([
      //           'error' => $parsed_json_result["error"],
      //           ]
      //       );
      //   }
        
      //   // return redirect('/profile')->withErrors([
      //   //     'add_passkey_success' => "Passkey has been added successfully",
      //   // ]);

      //   dd($result);

      // // $handshake_id = $parsed_json_result["handshake"]["id"];
      // // $authenticatorAttachment = $parsed_json_result["handshake"]["challenge"]["publicKey"]["authenticatorSelection"]["authenticatorAttachment"];
      // // $id = $parsed_json_result["handshake"]["challenge"]["publicKey"]["user"]["id"];
      // // $rawId = "e";
      // // $attestationObject = $parsed_json_result["handshake"]["challenge"]["publicKey"]["attestation"];
      // // $clientDataJSON = $parsed_json_result["user"];
      // // $transports_string = "e";
      // // $type = "e";
      // // $user_id = $parsed_json_result["user"]["id"];

      // $data = '{
      //   "handshake_id": "OfNSddgiv6JKRBFJdVuBWhcB",
      //   "handshake_response": {
      //     "authenticatorAttachment": "platform",
      //     "clientExtensionResults": {},
      //     "id": "string",
      //     "rawId": "string",
      //     "response": {
      //       "attestationObject": "string",
      //       "clientDataJSON": "string",
      //       "transports": [
      //         "string"
      //       ]
      //     },
      //     "transports": [
      //       "string"
      //     ],
      //     "type": "string"
      //   },
      //   "user_id": "string"
      // }';

      // $url = "https://auth.passage.id/v1/apps/$app_id/register/webauthn/finish";


      // $ch = curl_init($url);

      // curl_setopt($ch, CURLOPT_HTTPHEADER, 
      //     array(
      //         'Content-Type: application/json',
      //     )
      // );

      // // curl_setopt($ch, CURLOPT_HEADER, false);
      // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      // //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
      // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

      // $result2 = curl_exec($ch);

      // curl_close($ch);

      // $parsed_final_json_result = json_decode($result2, true);

      // dd($parsed_final_json_result);
    }
}
