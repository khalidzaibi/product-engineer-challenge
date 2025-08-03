<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# 🛠️ Product Engineer Challenge

A fully containerized Laravel + Vue.js application with user, task, and team management, built using Docker.

-   I've also included the Postman API collection (Product-Engineer.postman_collection.json) in the repository for easier testing

---

## ✅ Full Project Setup Guide

Follow all steps below to install and configure this project on your local machine.

---

## 📋 Prerequisites

-   [Docker](https://www.docker.com/)

---

## ⚙️ Setup (Zero Manual Steps)

### 1. Clone the Repository

```bash
git clone https://github.com/khalidzaibi/product-engineer-challenge.git
cd product-engineer-challenge
```

### 2. Copy the Environment File

```bash
cp .env.example .env
```

### 3. Start the Project

```bash
docker-compose up --build -d
```

## Common Docker Commands

```bash
# Stop and remove containers
docker-compose down
```

```bash
# Rebuild all services
docker-compose build --no-cache
```

```bash
# View container logs
docker-compose logs -f
```

```bash
# open container terminal
docker exec -it laravel-app
```

## 🔑 Access the Services

-   http://localhost
-   Email: admin@admin.com
-   Password: password

---

## 📁 Project Overview

-   🔐 Authentication with Laravel Sanctum
-   ✅ Task Management (assign, track, filter)
-   👥 Team Module (Many-to-Many users <-> teams)
-   📊 Dashboard Stats API
-   🧪 Seeder for Users, Tasks, Teams
-   📁 Repository Pattern + API Resources
-   🐳 Fully Dockerized with no manual steps

## 📁 Folder Structure

```bash
product-engineer/
├── app/                 # Laravel application core (Controllers, Models, etc.)
├── docker/              # Docker-related files
│   ├── entrypoint.sh    # Entrypoint script for initial Laravel setup
│   ├── Dockerfile       # PHP/Node Dockerfile
│   └── nginx/           # Nginx config (default.conf, etc.)
├── docker-compose.yml   # Docker service definitions
├── .env                 # Environment config
├── .gitignore
├── composer.json
├── package.json
└── README.md

```

## 👤 Author

Developed by [Muhammad Khalid](https://github.com/khalidzaibi)

---
