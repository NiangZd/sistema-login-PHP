<?php
        $curl = curl_init();

        $data = array(
            'phone' => '5584981749795',
            'message' => 'TESTANDO ENVIO Z-API'
        );

        $jsonData = json_encode($data);

        $headers = array(
            'Content-Type: application/json'
        );

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.z-api.io/instances/3B8E9C8C194F40306F640A394DBBCDD9/token/3B8E9C8C197650ECCCE80A394DBBCDD9/send-text',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $jsonData,
            CURLOPT_HTTPHEADER => $headers
        ));

        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        if ($error) {
            echo 'Ocorreu um erro ao enviar a mensagem: ' . $error;
        } else {
            echo 'Mensagem enviada com sucesso!';
        }
    ?>