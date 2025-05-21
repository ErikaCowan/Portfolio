<?php
if (
    isset($_POST['name']) &&
    isset($_POST['email']) &&
    isset($_POST['subject']) &&
    isset($_POST['comment'])
) {
    $name    = trim($_POST['name']);
    $email   = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $comment = trim($_POST['comment']);

    // build HTML message
    $html = "<table>
                <tr><td><strong>Name:</strong></td><td>{$name}</td></tr>
                <tr><td><strong>Email:</strong></td><td>{$email}</td></tr>
                <tr><td><strong>Subject:</strong></td><td>{$subject}</td></tr>
                <tr><td><strong>Comment:</strong></td><td>{$comment}</td></tr>
             </table>";

    // load PHPMailer
    require __DIR__ . '/smtp/PHPMailerAutoload.php';
    $mail = new PHPMailer(true);

    // SMTP configuration
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->Port       = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth   = true;
    $mail->Username   = '';
    $mail->Password   = '';

    // sender & recipient
    $mail->setFrom($email, $name);
    $mail->addAddress('erikasbusinessolutions@gmail.com', 'Erika Cowan');

    // email format
    $mail->isHTML(true);
    $mail->Subject = '(Elora) New Contact Info';
    $mail->Body    = $html;

    // optional: disable peer verification if needed
    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer'       => false,
            'verify_peer_name'  => false,
            'allow_self_signed' => false
        ]
    ];

    // send & respond
    if ($mail->send()) {
        echo 'Message Sent';
    } else {
        http_response_code(500);
        echo 'Error Occur: ' . $mail->ErrorInfo;
    }
}
?>