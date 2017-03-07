@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../crossjoin/browscap/scripts/browscap
php "%BIN_TARGET%" %*
