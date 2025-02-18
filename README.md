# 🌆 Gestión de Actividades Municipales (GAM)

## 📌 Descripción  
**GAM** es una aplicación web encargada por el **Ayuntamiento de Vitoria-Gasteiz** para facilitar la gestión de actividades en los centros cívicos de la ciudad. Su objetivo principal es mejorar la eficiencia en la administración y participación ciudadana, permitiendo a los usuarios consultar e inscribirse en actividades de manera sencilla, y a los técnicos municipales gestionar su mantenimiento de forma efectiva.  

La aplicación permite:  
- 📅 Consultar actividades disponibles con filtros avanzados.  
- 📝 Inscribirse fácilmente en las actividades.  
- 🔧 Gestionar el mantenimiento de actividades por parte de los administradores.  

---

## 🛠️ Tecnologías Utilizadas  

### **Frontend**  
- Vue.js  
- Bootstrap  
- Sass  

### **Backend**  
- Laravel (PHP)  
- MySQL  

### **Herramientas de Desarrollo**  
- Visual Studio Code  
- PhpMyAdmin (gestión de base de datos)  
- GitHub (control de versiones)  
- WhatsApp y Discord (comunicación del equipo)  

---

## 📥 Instalación y Configuración  

### **Requisitos Previos**  
- PHP 8.2  
- Composer  
- Node.js y npm  
- MySQL  

### **Pasos para la Instalación**  
1. Clonar el repositorio:  
   ```sh
   git clone https://github.com/usuario/gestion-actividades.git
   cd gestion-actividades
   ```  
2. Instalar dependencias del backend:  
   ```sh
   composer install
   php artisan migrate
   ```  
3. Instalar dependencias del frontend:  
   ```sh
   npm install
   ```  
4. Ejecutar el servidor de desarrollo:  
   ```sh
   php artisan serve
   ```  
5. Iniciar el frontend:  
   ```sh
   npm run dev
   ```  

---

## ⚡ Funcionalidades Principales  

### **Usuarios Ciudadanos**  
- 🔍 Consultar actividades con filtros avanzados.  
- 📝 Inscribirse en actividades de interés.  

### **Administradores**  
- ➕ Crear nuevas actividades.  
- ✏️ Editar y actualizar actividades existentes.  
- ❌ Eliminar actividades si es necesario.  
- 🛠️ Gestionar el mantenimiento de las actividades.  

---

## 🎨 Diseño  

### **Guía de Estilos y Gama Cromática**  
La aplicación tiene una interfaz amigable con colores frescos y neutros para una mejor experiencia de usuario.  

- **Colores principales:**  
  - Verde turquesa: `#90C4AC` (RGB 144, 196, 172)  
  - Verde esmeralda: `#198553` (RGB 25, 133, 83)  
  - Rojo: `#DC3545` (RGB 220, 53, 69)  
  - Amarillo: `#FFC107` (RGB 255, 193, 7)  

### **Arquitectura del Proyecto**  
- **Frontend:** Vue.js y Bootstrap para una SPA eficiente.  
- **Backend:** API REST con Laravel y MySQL.  
- **Control de versiones:** GitHub.  

---

## 🔮 Futuras Implementaciones  
- 📌 Despliegue en un servidor en producción.  
- ⚡ Optimización de rendimiento y código.  
- 📱 Mejora de responsividad en dispositivos móviles.  

---

## 👥 Contribución  
Si deseas contribuir al proyecto:  
1. Haz un fork del repositorio.  
2. Crea una nueva rama (`git checkout -b feature-nueva-funcionalidad`).  
3. Realiza tus cambios y haz un commit (`git commit -m "Nueva funcionalidad"`).  
4. Sube los cambios a tu rama (`git push origin feature-nueva-funcionalidad`).  
5. Abre un Pull Request.  

---

## 📜 Licencia  
Este proyecto está bajo la licencia **MIT**. Consulta el archivo `LICENSE` para más información.  

---

## 📧 Contacto  
- **Desarrolladores:** Joseba Fernández, Oier Albéniz, Leire de las Heras  
- **Correo de contacto:**  
    - joseba.fernandez@ikasle.egibide.org  
    - oier.albeniz@ikasle.egibide.org  
    - leire.delasheras@ikasle.egibide.org  

© 2025 Joseba Fernández - Leire de las Heras - Oier Albéniz. Todos los derechos reservados.  

