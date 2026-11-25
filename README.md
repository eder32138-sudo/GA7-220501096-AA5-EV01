# GA7-220501096-AA5-EV01 — Servicio web de registro e inicio de sesión

**Aprendiz:** Eder Luis Díaz Mercado  
**Ficha:** 3186587  
**Proyecto de referencia:** TAYRA  
**Tecnología propuesta:** PHP 8+, MySQL y API REST con respuestas JSON.

## 1. Objetivo
Construir un servicio web sencillo que permita registrar usuarios e iniciar sesión. La API recibe usuario y contraseña y responde si la autenticación fue satisfactoria o si ocurrió un error.

## 2. Requisitos
- PHP 8.0 o superior con extensión PDO MySQL habilitada.
- MySQL o MariaDB (por ejemplo, el incluido en XAMPP).
- Git.
- Servidor Apache o servidor integrado de PHP.

## 3. Preparación de la base de datos
1. Inicie MySQL desde XAMPP.
2. Abra phpMyAdmin.
3. Importe el archivo `database/usuarios.sql`.
4. Revise los datos de conexión en `api/config.php`.

La configuración inicial usa `localhost`, base de datos `tayra_auth`, usuario `root` y contraseña vacía. Si su instalación tiene otra contraseña, actualice `api/config.php`.

## 4. Ejecución local
Desde la carpeta del proyecto, ejecute:

```bash
php -S localhost:8000 -t .
```

La API queda disponible en:
- `POST http://localhost:8000/api/register.php`
- `POST http://localhost:8000/api/login.php`

## 5. Ejemplos de solicitudes
Enviar el encabezado `Content-Type: application/json`.

**Registro**
```json
{
  "usuario": "eder",
  "contrasena": "ClaveDePrueba123"
}
```

**Inicio de sesión**
```json
{
  "usuario": "eder",
  "contrasena": "ClaveDePrueba123"
}
```

La contraseña se almacena usando `password_hash`; no se guarda como texto legible.

## 6. Versionamiento con Git
Desde la carpeta del proyecto:

```bash
git init
git add .
git commit -m "Primera versión del servicio de autenticación"
```

Cree en GitHub un repositorio público llamado `GA7-AA5-EV01-TAYRA`. Luego conecte el repositorio local usando la URL HTTPS real que GitHub le entregue:

```bash
git branch -M main
git remote add origin https://github.com/eder32138-sudo/GA7-220501096-AA5-EV01
git push -u origin main
```

No deje el texto `https://github.com/eder32138-sudo/GA7-220501096-AA5-EV01`: reemplácelo por la dirección real de su repositorio.

## 7. Verificación pendiente
Las solicitudes deben ejecutarse en Postman o una herramienta equivalente. Registre capturas reales del registro correcto, inicio de sesión correcto y credenciales incorrectas. No incluya capturas simuladas ni afirme que una prueba fue realizada si todavía no la ejecutó.

## 8. Contenido de la entrega
- Carpeta `api` con el código fuente.
- Carpeta `database` con el script SQL.
- Este archivo de instrucciones.
- `enlace_repositorio.txt`, para pegar la URL real de GitHub.

Antes de entregar, comprima la carpeta con el nombre `EDER_DIAZ_AA5_EV01.zip`.
