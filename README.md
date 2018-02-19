# Symfony News Rest

I've used Symfony framework (for the first time) 
to implement the RESTful service for topics and articles. It was written in 
PHP 7.1, symfony 4.0.4. The system was run on Ubuntu 16.04
using PHP built in server.
As for the database, I used mysql local database. I included
sql script in the project root directory which can be used if 
you want to test the system.

What I focused on was the quality of solution regarding
well assembled architecture which can be easily used, extended 
and mantained. 



# Architecture


Dependency injection (IoC) was realized through constructor.

I've used one of the standard layered architecture that is used in Java web programming,
DAOs for data accessing, services for executing bussiness logic, serializers
for transforming models into arrays and facades which represent simplified 
interface for using the data manipulation subsystem.

The implemented system provides example of partial data fetching in which client 
needs to request specific atributes of models if he wants the API to return them.
When specific topic or topic list is requested, the request can contain "extras"
which match desired fields such as articles.
Usage example: /api/topics/1?extras[]=articles

# Possible Improvements

1. I didn't use any interfaces for layering thus the system is tightly coupled.
Adding interfaces to DAO, Service and Facade layers would be highly recommendable.
SOLID principles would be easier to achieve with usage of interfaces.

2. The service layer was so simple (in this specific task) that it basically only called DAOs 
and returned what DAOs returned. For small performance improvement it would be possible
to remove that layer from the solution although it wouldn't be advisable if project
was to be expanded sometimes in the future.

3. Use some automatic serializer (avoid reinventing the wheel) which supports complex
serialization combinations. Although custom written serializers do offer a maximum control
over serialization, using existing libraries would be advisable if the speed of coding is
of importance.

4. Using funcional tests to test the whole service. Also cover whole code with unit tests.

5. Using PDO instead of mysqli (for migration purposes). Also using stored procedures in database and/or
prepared statements (to avoid SQL injection). Using pool of database connections instead of  initializing new 
connection for every request would drastically improve performance.

6. As the system is fairly simplisic it would be possible (for minor performance improvements) to 
convert all classes to static ones (because most of them are stateless) which would 
in essence convert the project from object oriented to functional. What I found wierd was that
symfony creates new objects (controllers->facades->services->daos) for every new request, even 
when I explicitly put "shared: true" in services.yaml (which is the default value btw). I think 
that PHP's built in server is to blame, but not sure.

7. Convert all static classes (such as ErrorService and serializers) to normal classes to
adhere to the notion that globally available functions/methods are cancer for larger projects
in terms of extensibility which cannot be achieved easily if functions are static and used all over the place.

