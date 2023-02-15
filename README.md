### Initial setup
1: `git clone git@github.com:alexeves/wireless-logic.git`

2: `cd wireless-logic`

3: `make build`

### Available actions:
Run the app: `make run`

Run the tests: `make run-tests`

Run the code analysis tools: `make run-code-analysis`

### Approach
I have adopted a "Hexagonal Architecture" approach, to allow a test driven approach using mocks. I began with a high level use case (or acceptance) test, using a mock repository, and built the domain layer out from there. This allowed me to build and test a fully functional application and domain layer. It was then a process of wiring up the infrastructure, in this case the console command and the product repository.

The code contains 3 layers: Infrastructure, Application, and Domain. The Application layer coordinates the interaction between the incoming ports (the console command in this case), and the Domain.

The Infrastructure layer contains all services that reach out to external services. Classes in here will always implement a Domain interface, to allow for easy replacement and mocking.

### Next steps
Assuming that the HTML content for the products does not change much, it would be wise to implement a caching layer, to cache the HTML that is fetched by the product repository.
