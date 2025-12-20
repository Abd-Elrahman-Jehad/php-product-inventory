## Docker & GitHub Basics 

### Project Name(PHP Product Inventory)

---

## Project Description
This project is a simple PHP web application created for educational purposes.  
The main goal of this assignment is to demonstrate the use of **GitHub** for version control and **Docker** for containerizing applications.

The project was dockerized as required in **OS Lab – Assignment #2 (Docker & GitHub Basics)**.

---

## Technologies Used
- PHP
- Apache Web Server
- Docker
- Git & GitHub

---

## How to Run the Project Without Docker
1. Download the project files.
2. Place them inside a local PHP server (such as XAMPP or WAMP).
3. Start Apache.
4. Open the project in the browser.

---

## How to Run the Project Using Docker

### Step 1: Build the Docker Image
```bash
docker build -t php-product-inventory .
Step 2: Run the Docker Container
docker run -p 8080:80 php-product-inventory
Step 3: Open the Project in Browser
http://localhost:8080
Docker Explanation

The project uses an official PHP image with Apache.

The Dockerfile copies the project files into the Apache web directory.

The container runs the project on port 80 and is mapped to port 8080 on the host machine.