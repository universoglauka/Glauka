## Trabajo por Lara Florian y Mayra Yañez DWT4AV

El trabajo presentado es una ticktera para que puedan subir sus obras grupos aunque no sean conocidos o por hobby.

Se pueden registrar como usuarios comunes o como productores.

En el home se muestran las obras más recientes y un filtrado por clasificación.
Al acceder como productor, solo se podrá ver el detalle de las obras propias. Hay una sección que agrupa todas las obras creadas por el usuario y otra sección de dashboard para mantenerse al tanto del movimiento de la venta.
Los productores pueden subir sus obras, editarlas y eliminarlas luego de que el stock de entradas llegue a 0.

Los usuarios por el momento solo pueden simular la compra de entradas, ya que no hay una pasarela real de pago, pero se llega a restar de las entradas disponibles y se guarda el ticket de compra en la base de datos. Cuenta con un primer diseño de perfil donde se pueden ver sus datos e historial de compras. 

El trabajo está realizado con Laravel 12; está pensado ser estilizado con Bootstrap pero por el tiempo aún no hemos podido-
reemplazar todo lo que se generó de manera automática con Tailwind.


Para la autenticación se utilizo Laravel Breeze. 
Se es conciente del incorrecto uso de español e ingles y que deberian cambiarse algunos nombres para estar todo en un idioma.


## Iniciar el proyecto

* En phpMyAdmin crear una nueva carpeta con el nombre glauka e importar el .sql.

* Copiar la carpeta en el entorno local (como XAMPP).

* Abrir la carpeta en el editor de código y ejecutar los siguientes comandos:

composer install

npm install 

*Para correr el trabajo ejecutar en consola:

php artisan serve

