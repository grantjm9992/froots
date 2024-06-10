# Grant MacDonald Froots challenge

Welcome to the README file of the project from Grant MacDonald proposed as a solution to the challenge set by Froots.

## Project Overview

The project uses the API-Platform (https://api-platform.com) framework

## Prerequisites

To run the project, please ensure that you have Docker installed locally. Docker can be installed from here - https://www.docker.com/products/docker-desktop/

## Running with Makefile & Docker

Running the project with Docker allows us to install all the required PHP/Nginx/MySQL components whilst ensuring they're the correct version. There is a Makefile included in the project in order to make the set-up even smoother.

1. Open a command line tool and clone the git repository: ````git clone git@github.com:grantjm9992/froots.git````
2. Access the folder ````cd froots````
3. Run the installation command ````make all````

This will run a series of commands in series until everything is done. Once the process has completed (it will take a couple of minutes the first time), there will be some dummy data installed.

In order to stop all services, simply run ````make down````

If you have already set up the services and simply want to start the containers, use ````make up````


## Documentation

Assuming that no modifications were made to the Dockerfile / docker-compose.yml, the guys at API Platform kindly include documentation with the framework. To access said documentation, you can go here - http://localhost/api/docs?ui=re_doc . Here you will find a list of all the available endpoints as well as example schemas.

## Testing

### Manual Testing

We can manually test the API using the Postman collection included in the ./postman directory in the repository. There are requests for GET orders, GET products, POST login and GET orders/{id}/prodcuts, the last of which is protected and requires a valid JWT token in order to access.

Of course, other standard methods of testing APIs are also possible.

### Suite Testing

PHP Unit has been included in order to have some testing with a test suite. There is a command in the Makefile ```make test```` which will run all the tests for you directy.

Alternatively you can run them from within the docker container if preferred.
