<?php
require_once __DIR__ . '/config/database.php'; require_once __DIR__ . '/includes/functions.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: index.php?contact=sent#contact'); exit; }
if (!csrf_valid($_POST['csrf_token'] ?? null)) { http_response_code(400); exit('Your session expired. Please go back and try again.'); }
if (!empty($_POST['website'] ?? '')) { header('Location: index.php?contact=sent#contact'); exit; }
$name = trim((string)($_POST['name'] ?? '')); $email = trim((string)($_POST['email'] ?? '')); $subject = trim((string)($_POST['subject'] ?? '')); $message = trim((string)($_POST['message'] ?? ''));
$errors=[]; if($name==='' || mb_strlen($name)>100) $errors[]='Enter a name up to 100 characters.'; if(!filter_var($email,FILTER_VALIDATE_EMAIL) || strlen($email)>254) $errors[]='Enter a valid email address.'; if($subject==='' || mb_strlen($subject)>150) $errors[]='Enter a subject up to 150 characters.'; if($message==='' || mb_strlen($message)>5000) $errors[]='Enter a message up to 5,000 characters.';
if($errors){ $_SESSION['contact_errors']=$errors; $_SESSION['contact_old']=['name'=>$name,'email'=>$email,'subject'=>$subject,'message'=>$message]; header('Location: index.php?contact=error#contact'); exit; }
try { $stmt=$pdo->prepare('INSERT INTO contact_messages (name,email,subject,message,ip_hash) VALUES (:name,:email,:subject,:message,:ip_hash)'); $stmt->execute(['name'=>$name,'email'=>$email,'subject'=>$subject,'message'=>$message,'ip_hash'=>hash('sha256', ($_SERVER['REMOTE_ADDR'] ?? 'unknown') . (getenv('IP_HASH_SALT') ?: 'change-this-salt'))]); $_SESSION['contact_status']='success'; }
catch(Throwable $t){ error_log('Contact submission failed: '.$t->getMessage()); $_SESSION['contact_status']='error'; }
header('Location: index.php?contact=' . (($_SESSION['contact_status'] ?? '') === 'success' ? 'sent' : 'error') . '#contact'); exit;
