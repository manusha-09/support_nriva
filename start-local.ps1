$ErrorActionPreference = 'Stop'
$projectRoot = $PSScriptRoot
$xamppRoot = Split-Path (Split-Path $projectRoot -Parent) -Parent
$php = Join-Path $xamppRoot 'php\php.exe'
$apache = Join-Path $xamppRoot 'apache\bin\httpd.exe'
$mysql = Join-Path $xamppRoot 'mysql\bin\mysqld.exe'
if (-not (Get-Process mysqld -ErrorAction SilentlyContinue)) {
    $mysqlConfig = Join-Path $xamppRoot 'mysql\bin\my.ini'
    Start-Process -FilePath $mysql -ArgumentList ('--defaults-file="' + $mysqlConfig + '"', '--standalone') -WorkingDirectory $xamppRoot -WindowStyle Hidden
}
if (-not (Get-Process httpd -ErrorAction SilentlyContinue)) {
    Start-Process -FilePath $apache -WorkingDirectory (Join-Path $xamppRoot 'apache\bin') -WindowStyle Hidden
}
Push-Location $projectRoot
try {
    & $php artisan config:clear
    & $php artisan view:clear
    if ($LASTEXITCODE -ne 0) { throw 'Laravel cache cleanup failed.' }
} finally { Pop-Location }
$url = 'http://localhost/support.nriva.org/'
$ready = $false
for ($attempt = 0; $attempt -lt 15; $attempt++) {
    try {
        $response = Invoke-WebRequest $url -UseBasicParsing -TimeoutSec 5
        if ($response.StatusCode -eq 200) { $ready = $true; break }
    } catch { Start-Sleep -Seconds 1 }
}
if (-not $ready) { throw 'The site did not start. Check Apache/MySQL in the XAMPP Control Panel and port 80.' }
Write-Host "Support Ticketing System is running at $url"
Start-Process $url