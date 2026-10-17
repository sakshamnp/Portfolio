<?php
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
function e($value): string { return htmlspecialchars((string)($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
function csrf_token(): string { if (empty($_SESSION['csrf_token'])) { $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); } return $_SESSION['csrf_token']; }
function csrf_valid($token): bool { return is_string($token) && isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token); }
function setting(PDO $pdo, string $key, string $fallback=''): string { try { $s=$pdo->prepare('SELECT setting_value FROM site_settings WHERE setting_key=?'); $s->execute([$key]); $v=$s->fetchColumn(); return $v === false ? $fallback : (string)$v; } catch (Throwable $t) { return $fallback; } }
