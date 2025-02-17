# Usar imagen de Node.js
FROM node:16

# Establecer directorio de trabajo
WORKDIR /app

# Copiar archivos package.json y package-lock.json
COPY frontend/package*.json ./

# Instalar dependencias
RUN npm install

# Copiar el resto de archivos del frontend
COPY frontend/ .

# Construir la aplicación de Vue
RUN npm run build

# Copiar la carpeta dist al directorio de Nginx
COPY frontend/dist /var/www/frontend/dist

# Exponer puerto 8080 (si deseas acceder al frontend por este puerto)
EXPOSE 8080

# No es necesario ejecutar npm run serve en producción, lo sirve Nginx.
