## Docker & GitHub Basics

### Project Name (PHP Product Inventory)

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

## Verification of Git & Docker Installation

Before starting the deployment process, Git and Docker were verified to be installed correctly using the following commands:

```bash
git --version
docker --version

```

## Repository Cloning

The project repository was cloned from GitHub using the following commands:

```bash
git clone https://github.com/Abd-Elrahman-Jehad/php-product-inventory.git
cd php-product-inventory

```
## Docker Build Process

After cloning the repository, the Docker image was built successfully using the Dockerfile included in the project:

```bash
docker build -t php-product-inventory .
```

## Running the Docker Container

The Docker container was started using the following command:
```bash
docker run -d -p 8080:80 php-product-inventory
```

## Production URL

When running the project locally, it can be accessed using:
```bash
http://localhost:8080
```
When running the project on GitHub Codespaces, the application is accessed using the forwarded port URL generated automatically by Codespaces, for example:
```bash
https://humble-space-meme-q7grxv6vxq6j297r-8080.app.github.dev
```
## VPS Deployment Instructions

To deploy this project on a Virtual Private Server (VPS), follow these steps:

Install Git and Docker on the VPS.

Clone the project repository from GitHub.

Build the Docker image using the Dockerfile.

Run the Docker container and expose the required port.

Access the project using the VPS IP address and port number.

Example commands on a VPS:
```bash
git clone https://github.com/Abd-Elrahman-Jehad/php-product-inventory.git
cd php-product-inventory
docker build -t php-product-inventory .
docker run -d -p 8080:80 php-product-inventory
```