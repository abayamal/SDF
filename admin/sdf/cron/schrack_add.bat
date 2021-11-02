@echo off
schtasks /Create /TN XAMPP /TR "C:/xampp/php/php-win.exe C:/xampp/htdocs/sathira/admin/sdf/cron/index.php" /SC MONTHLY /MO 1
pause