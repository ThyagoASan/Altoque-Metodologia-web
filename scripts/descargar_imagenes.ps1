# Ejecutar desde la carpeta raíz del repositorio en PowerShell
$ErrorActionPreference = "Stop"
$destino = Join-Path $PSScriptRoot "..\FontEnd\imagenes"
New-Item -ItemType Directory -Force -Path $destino | Out-Null
$origen = "https://raw.githubusercontent.com/ThyagoASan/Proyecto-Altoque-_desarrollo_y_Arquitect_web/main/FontEnd/imagenes/"
$archivos = @("admin_fondo.jpg", "fondo_imagen_principal.jfif", "fondo_usuarios.jpg", "logo_al_toque.png", "lupa.png", "usuario.avif", "usuario.ico", "usuario1.ico")
foreach ($archivo in $archivos) {
    Invoke-WebRequest -Uri ($origen + $archivo) -OutFile (Join-Path $destino $archivo)
    Write-Host "Descargado: $archivo"
}
Write-Host "Recursos listos en: $destino"
