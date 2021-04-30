# Cruds en Laravel

Hecho en laravel y php 7

Tiene algunos estilos de CRUD que aprendí a hacer, la idea es crear un sistema pequeño pero muy completo y robusto.

Se agrega al listado de carpetas del `.gitignore` las siguientes carpetas del proyecto: `app`, `public/css` y `public/js` para evitar plagios (que ya ha pasado).

Este sistema sigue en desarrollo, pero se agregan imágenes demostrativas.

# Imágenes demostrativas para un CRUD de usuarios

# Crear usuario

![usuarioCrear](./public/img/crear_usuario.gif)

# Editar usuario
![usuarioEditar](./public/img/editar_usuario.gif)

# Bloquear/Desbloquear usuario

![usuarioBloquear](./public/img/bloquear_usuario.gif)

# Eliminar usuario

![usuarioEliminar](./public/img/eliminar_usuario.gif)

# Imágenes demostrativas para un CRUD de costos

# Datatables *details-control* y *server-side*

***Details-control*** es una capacidad de datatables de mostrar información adicional de una fila usando una fila hija.

***Server-side*** es recomendado de usar cuando se está trabajando con bases de datos con muchos registros. Con *server-side*, todas las acciones de paginación, búsqueda y ordenamiento que realiza datatables se transfieren al servidor. 

Con cada acción sobre la tabla que requiera modificarla (ordenar, buscar, paginar, u otros), dará como resultado una nueva solicitud Ajax para obtener los datos requeridos.

# Demostración de un CRUD de costos con datatables *details-control* y *server-side*

![costoDetailsControl](./public/img/demo_detailsControl_costos.gif)

# Crear costo

![costoCrear](./public/img/crear_costo.gif)

# Editar costo

![costoEditar](./public/img/editar_costo.gif)

# Bloquear/Desbloquear costo

![costoBloquear](./public/img/bloquear_costo.gif)

# Eliminar costo

![costoEliminar](./public/img/eliminar_costo.gif)


Este sistema usa:
* Bootstrap
* Toastr
* SweetAlert2
* DataTables
* MySql
* Diseño responsive
* Font awesome
* Date range picker
* Moment JS
* Imask
* jQuery
