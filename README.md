## Proyecto de Laravel para Gestión de Transacciones

Este repositorio contiene un proyecto de Laravel diseñado para ayudar a los usuarios a gestionar sus transacciones financieras. Permite crear, ver, editar, eliminar y descargar transacciones junto con sus detalles asociados. La aplicación utiliza Laravel como framework backend, MySQL como base de datos y Bootstrap para el diseño frontend.

### Pasos para Ejecutar el Proyecto

Para ejecutar este proyecto en tu máquina local, sigue estos pasos:

1. **Clonar el Repositorio**

   Clona este repositorio en tu máquina local utilizando el siguiente comando:

    git clone <https://github.com/tu-usuario/proyecto-laravel.git>

2. **Instalar Dependencias**

    Accede al directorio del proyecto y ejecuta el siguiente comando para instalar las dependencias del proyecto:

    cd proyecto-laravel
    composer install

3. **Configurar el Entorno**

    Copia el archivo `.env.example` y renómbralo como `.env`. Luego, genera una nueva clave de aplicación utilizando el siguiente comando:

    php artisan key

    Asegúrate de configurar la conexión a tu base de datos en el archivo `.env`.

4. **Migrar la Base de Datos**

    Ejecuta las migraciones para crear las tablas necesarias en tu base de datos:
    php artisan migrate

5. **Iniciar el Servidor Local**

    Inicia el servidor de desarrollo de Laravel ejecutando el siguiente comando: php artisan serve

Esto iniciará el servidor en `http://localhost:8000` por defecto.

6. **Acceder a la Aplicación**

Abre tu navegador web y accede a `http://localhost:8000` para ver la aplicación en funcionamiento.

### Descripción del Proyecto

Este proyecto, aparentemente pequeño, se centra en la gestión de transacciones financieras. Los usuarios pueden realizar las siguientes acciones:

- **Crear Transacciones:** Los usuarios pueden registrar nuevas transacciones especificando detalles como la fecha, cantidad, categoría y tipo de transferencia.
- **Ver Transacciones:** Pueden ver una lista de todas las transacciones registradas junto con sus detalles asociados.
- **Editar Transacciones:** Tienen la capacidad de editar los detalles de las transacciones existentes según sea necesario.
- **Eliminar Transacciones:** Pueden eliminar transacciones que ya no son relevantes.
- **Descargar Transacciones:** Los usuarios tienen la opción de descargar un informe de sus transacciones en un formato específico.

### Tecnologías Utilizadas

Este proyecto se desarrolló utilizando las siguientes tecnologías:

- **Laravel:** Framework de PHP para el desarrollo rápido y eficiente de aplicaciones web.
- **MySQL:** Sistema de gestión de bases de datos relacional utilizado para almacenar datos de la aplicación.
- **Bootstrap:** Framework frontend de código abierto para diseño de sitios web y aplicaciones web responsivas.

### Motivación y Objetivos

El principal objetivo de este proyecto es practicar y mejorar mis habilidades en el desarrollo de aplicaciones web, especialmente en el desarrollo backend utilizando Laravel. Al construir esta aplicación, he podido aprender sobre la interacción con la base de datos, la validación de formularios, la gestión de sesiones de usuario y la creación de acciones interactivas con el usuario. Además, he ganado experiencia en el diseño frontend utilizando Bootstrap para crear interfaces de usuario atractivas y responsivas.
