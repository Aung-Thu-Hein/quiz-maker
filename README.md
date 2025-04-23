# Quiz Maker REST API

After I have learned core backend concepts such as REST API, database, docker, CI/CD, design pattern and so on, I build an application **from scratch** to apply all the concept I have learned. This app follows **Open API Specification**. You can check in **api_documentation** folder to understand the api structure. In this repository you can learn following concepts:

- **Open API Specification, Swagger UI and writing api documentation**
- **DI container, routing system, JWT, system configuration, database connection class, Request and Response handling**
- **Service, DAO layer structure**
- **Unit testing**
- **CI/CD**
- **building docker container service**
- **DDL with MySQL**

## Folder Structure

The **core** folder contains

- **Service Container(DI container)** to resolve dependencies
- **Routing system** which is most likely from Laravel
- **Database class** to peform database connection and query operation
- **System configuration** which environment variables and constants
- **Request and response classes** that handle request and send back to response(Json) to client
- **JWT authentication system** from scratch

The **src** folder contains application logics and data modeling classes (Quiz, Question and User), In each folder there are following layers

- **Controllers** which handle incoming request, handle errors and response back to the client
- **Service layer** which contain business logic 
- **DAO layer** which is responsible for performing query operation
- **Model classes** which are built by using Builder, Factories pattern (Quiz, Question and User)

The **migration** folder contains sql files which is responsible for database migration.  
The **tests** folder contain **unit testing** for model classes Question and Quiz.  
The **.github** folder contains **CI/CD** operation using **GitHub Action**.  
The **swagger_ui** folder for visualization and interacting with the API’s resources without having any of the implementation logic in place.  

## Running the Project with Docker

This project uses Docker to simplify setup and deployment. There are three running docker services 
1. web server (Nginx)
2. application (PHP)
3. database (MySQL)

### Prerequisites

- Make sure [Docker](https://www.docker.com/products/docker-desktop) is installed on your system.

### Run the Application

Once Docker is installed, you can run the application with the following command:

```bash
docker compose up --build
```
