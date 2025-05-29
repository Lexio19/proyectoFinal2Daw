📦 Proyecto VisiTahal

Tahal es un bonito pueblo enclavado en el centro de la Sierra de los Filabres, en Almería. El año pasado, el ayuntamiento decidió construir unos bungalós justo a la entrada del pueblo para que los visitantes pudieran hacer noche y conocer mejor el sitio y las estupendas actividades que reunen a todos los vecinos del lugar.

🚀 Tecnologías utilizadas
PHP 8.2

MySQL

Docker

HTML/CSS/Bootstrap

JavaScript

📁 Estructura del proyecto

html/

    /principal --> Archivos principales de la web
    
    /controladores --> Lógica del backend 
    
    /conexion --> Contiene la clase que permite la conexión con la base de datos
    
    /funcionesValidacion --> Contiene el archivo que valida todos los datos que introducen los usuarios
    
sql/ --> Contiene un backup de la base de datos

docker-compose.yml --> Configuración del entorno Docker

Dockerfile --> Instrucciones para construir el contenedor de Apache

PROYECTO VISITAHAL.sql --> La base de datos del proyecto

README.md --> Información del proyecto

🐳 Requisitos

🔧 Instrucciones para ejecutar el proyecto

Para Windows 🖼️

1. Instalar Git Bash

2. Instalar Docker

3. Clona el repositorio. Abre Git Bash en la carpeta en la que quieras clonar el proyecto y escribe:

git clone https://github.com/Lexio19/proyectoFinal2Daw.git

4. Meterse dentro de la carpeta clonada y con git bash levantar los contenedores con Docker:

docker-compose up -d

4. Acceder al sitio web en tu navegador:

http://localhost

Para Linux 🐧

1. Tener git instalado

sudo apt update && sudo apt install git -y

2. Clonar el repositorio en la carpeta donde lo queramos

git clone https://github.com/Lexio19/proyectoFinal2Daw.git
cd repositorio

3. Levantar los contenedores del proyecto

# Instalar Docker si no lo tienes
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh

# Instalar Docker Compose (si es necesario)
sudo apt install docker-compose -y

# Levantar contenedores
docker-compose up -d 




✅ Usuarios de prueba

Admin: admin@gmail.com / AdminWeb123

Usuario: elloco@gmail.com / Alex123





