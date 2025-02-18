# Usa Node.js para compilar el frontend
FROM node:18 AS build

# Configura el directorio de trabajo
WORKDIR /app

# Copia los archivos del frontend
COPY . .

# Instala dependencias y construye el proyecto
RUN npm install && npm run build

# Usa Nginx para servir los archivos estáticos
FROM nginx:alpine

# Copia los archivos estáticos generados en la fase de compilación
COPY --from=build /app/dist /usr/share/nginx/html

# Expone el puerto 80
EXPOSE 80

# Inicia Nginx
CMD ["nginx", "-g", "daemon off;"]
