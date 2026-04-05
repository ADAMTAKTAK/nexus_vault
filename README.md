# 👾 NEXUS VAULT - Hardware E-Commerce

> *">_ Secure hardware acquisition protocol initialized."*

## 📄 Descripción
Este proyecto es una plataforma de comercio electrónico Full-Stack especializada en la venta de hardware de computadora. Con una identidad visual oscura inspirada en interfaces de terminal (Cyberpunk/Coder) y detalles en colores neón (Cyan y Magenta), la aplicación ofrece una experiencia inmersiva y altamente responsiva para la adquisición de componentes.

Nexus Vault evolucionó integrando un backend robusto en PHP puro y una base de datos MySQL, garantizando la seguridad mediante el hasheo de contraseñas, control de acceso por roles (Usuario/Administrador) y un sistema de carrito de compras transaccional; todo esto manteniendo un diseño fluido que se adapta perfectamente desde monitores ultra-wide hasta pantallas móviles como el iPhone SE.

## 🚀 Cómo usar la Web
La navegación en Nexus Vault está dividida según el nivel de acceso del usuario:

### >_ PERFIL DE CLIENTE (Usuario Normal)
1.  **Catálogo Global (`index.php`):**
    * Exploración del inventario de hardware con tarjetas estilo bloque de código (`struct`).
    * Barra de búsqueda unificada que permite buscar componentes por texto y filtrarlos por precio (Ascendente/Descendente).
2.  **Sistema de Carrito (`cart.php`):**
    * Adición de hardware desde la vista de detalles.
    * Cálculo matemático en tiempo real del subtotal y el total general.
    * Funcionalidad de *Checkout* que vacía el carrito y genera una factura digital (`invoice_view.php`) lista para imprimir.
3.  **Gestión de Perfil (`profile.php`):**
    * Creación de cuenta con validación de contraseñas y encriptación nativa (`password_hash`).
    * Actualización de datos personales y credenciales de acceso.

### >_ ROOT ACCESS (Administrador)
Al iniciar sesión con una cuenta de nivel `admin`, se desbloquea el acceso al `[ADMIN_SYS]`:
1.  **Gestión de Hardware (`admin_products.php`):**
    * Panel CRUD para registrar nuevo inventario, actualizar precios/descripciones y purgar (eliminar) componentes obsoletos del sistema.
2.  **Gestión de Usuarios (`admin_users.php`):**
    * Panel de supervisión de cuentas registradas.
    * Permite ascender usuarios a administradores `[MAKE_ADMIN]`, revocar poderes y eliminar registros completos de la base de datos de forma segura.

## 🛠 Tecnologías Empleadas
Este proyecto demuestra buenas prácticas de desarrollo, separando la lógica del diseño y priorizando la seguridad:

* **Frontend:** HTML5 semántico y CSS3 avanzado (variables globales, Flexbox, Grid, funciones matemáticas como `clamp()` para tipografía responsiva y `overflow-x` para protección de tablas en móviles).
* **Backend:** PHP puro estructurado bajo un modelo básico MVC para el procesamiento de datos, manejo de variables de sesión (`$_SESSION`) y enrutamiento.
* **Seguridad:** Consultas preparadas (Prepared Statements) contra inyecciones SQL y funciones nativas de PHP para el hasheo de contraseñas.
* **Base de Datos:** MySQL relacional (4 tablas conectadas: `users`, `products`, `cart`, `invoices`).
* **Tipografía:** Google Fonts integrando `Fira Code` para la lectura general de consola y `Orbitron` para los títulos principales.

## 💻 Instalación y Ejecución
Requiere un entorno de servidor local (como Laragon, XAMPP o WAMP) para funcionar correctamente:

1.  **Clonar el repositorio:**
    Abre tu terminal en la carpeta raíz de tu servidor web (ej. `www` en Laragon o `htdocs` en XAMPP) y ejecuta:
    ```bash
    git clone [https://github.com/ADAMTAKTAK/nexus_vault.git](https://github.com/ADAMTAKTAK/nexus_vault.git)
    cd nexus_vault
    ```

2.  **Configurar la Base de Datos:**
    * Abre tu gestor de bases de datos (ej. `http://localhost/phpmyadmin`).
    * Crea una nueva base de datos llamada exactamente `nexus_vault` (cotejamiento `utf8mb4_spanish_ci`).
    * Importa el archivo `.sql` que se encuentra en la carpeta principal del proyecto para generar la estructura de tablas.

3.  **Ejecutar:**
    * Abre tu navegador web y dirígete a `http://localhost/nexus_vault/index.php`.
    
## 📂 Estructura del Proyecto
El código sigue una organización modular separando las vistas, los controladores y los modelos:

```text
nexus_vault/
├── admin/                           # Vistas exclusivas del panel de control
│   ├── admin_dashboard.php          # Hub principal de administración
│   ├── admin_products.php           # CRUD de inventario
│   ├── admin_edit_product.php       # Formulario de actualización de hardware
│   ├── admin_users.php              # CRUD de clientes y roles
│   └── admin_edit_user.php          # Formulario de actualización de cuentas
├── assets/products/                 # Directorio de recursos multimedia (imágenes del hardware)
├── controllers/                     # Lógica de negocio (Actions)
│   ├── admin_product_controller.php # Procesamiento CRUD de hardware
│   ├── admin_user_controller.php    # Procesamiento CRUD de usuarios
│   ├── create_user_controller.php   # Lógica de registro y hasheo
│   ├── login_controller.php         # Verificación de credenciales y sesiones
│   └── checkout_controller.php      # Lógica transaccional del carrito
├── model/                           # Lógica de datos
│   └── conn.php                     # Credenciales y conexión a la base de datos MySQL
├── *.php                            # Vistas públicas (index, login, cart, profile, etc.)
├── styles.css                       # Hojas de estilo maestro y media queries responsivos
├── nexus_vault.sql                  # (Asegúrate de exportar tu DB aquí)
└── README.md                        # Documentación del proyecto
