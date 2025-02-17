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

# Exponer puerto
EXPOSE 8080

# Comando para ejecutar el servidor de Vue
CMD ["npm", "run", "serve"]
