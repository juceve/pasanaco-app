# 🚀 Laravel 11 + Jetstream + Livewire + Tailwind CSS – Admin Template

[![Laravel](https://img.shields.io/badge/Laravel-11-red?logo=laravel&logoColor=white)](https://laravel.com/)
[![Livewire](https://img.shields.io/badge/Livewire-3.x-blue?logo=laravel&logoColor=white)](https://livewire.laravel.com/)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38bdf8?logo=tailwindcss&logoColor=white)](https://tailwindcss.com/)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)
[![GitHub Repo](https://img.shields.io/badge/GitHub-juceve/template--admin--laravel11--tailwindcss-black?logo=github)](https://github.com/juceve/template-admin-laravel11-tailwindcss.git)

> 🎯 Plantilla profesional y minimalista para desarrollo ágil con Laravel 11, Jetstream, Livewire y Tailwind CSS.

---

## 📦 Tecnologías Incluidas

- ⚙️ **Laravel 11** – Framework backend PHP moderno.
- 🔐 **Jetstream** – Autenticación y gestión básica de usuarios.
- ⚡ **Livewire 3.x** – Componentes dinámicos sin escribir JS.
- 🎨 **Tailwind CSS 3.x** – Framework CSS utility-first.
- 🛠️ **Alpine.js** – Interactividad ligera en el frontend (incluido por Jetstream).
- 📜 **PHP 8.2+** – Requerido.

---
## 🎯 Características Principales
🔐 Autenticación completa (login, registro, recuperación).

📊 Dashboard básico listo para personalizar.

⚡ Componentes dinámicos con Livewire.

🎨 Diseño responsive y limpio con Tailwind CSS.

🛡️ Estructura segura, modular y escalable.

💡 Ideal como base para proyectos administrativos.

📂 Estructura del Proyecto
plaintext
Copiar
Editar
/app
/config
/resources/views
/resources/css
/app/Http/Livewire
/routes/web.php
/tailwind.config.js

🎨 Personalización
Reemplaza logo y favicon en:

/resources/views/components/application-logo.blade.php

/resources/views/layouts/app.blade.php

Archivo opcional /config/admin.php (si aplica)

Personaliza estilos en:

/resources/css/app.css

tailwind.config.js

📈 Roadmap (Sugerido)
 Crear módulos CRUD con Livewire.

 Añadir dashboards gráficos.

 Soporte multi-idioma.

 Interfaz oscura / clara (dark mode).

 Deploy optimizado (Vite / Laravel Mix opcional).

🤝 Contribuciones
¿Ideas, mejoras o errores?
Abre un issue o haz un pull request. ¡Colabora con este proyecto!

📃 Licencia
Publicado bajo licencia MIT.
Consulta el archivo LICENSE para más detalles.

✨ Créditos
Desarrollado con pasión por Julico.
Proyecto disponible en:
👉 https://github.com/juceve/template-admin-laravel11-tailwindcss.git

## 🚀 Instalación Rápida

```bash
git clone https://github.com/juceve/template-admin-laravel11-tailwindcss.git
cd template-admin-laravel11-tailwindcss
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install && npm run dev
php artisan serve

---



