# Quotes API


[PHPUnit code coverage report](https://coverage-report-quotes-api.now.sh/)


## Installation

Use [docker](https://docs.docker.com/install) to install the container services.

```bash
docker-compose up -d
```

This command will install an instance of  Nginx and Redis services.


## Usage

You can get the postman collection using the button:

[![Run in Postman](https://run.pstmn.io/button.svg)](https://app.getpostman.com/run-collection/7c680d1967683c707f56#?env%5BQuotes%20API%20%3A%3A%20Local%5D=W3sia2V5IjoiUXVvdGVzQVBJRW5kcG9pbnQiLCJ2YWx1ZSI6Imh0dHA6Ly8xMC4yNTQuMjU0LjI1NCIsImVuYWJsZWQiOnRydWV9LHsia2V5IjoiUXVvdGVzQVBJUG9ydCIsInZhbHVlIjoiODA4MCIsImVuYWJsZWQiOnRydWV9XQ==)

There are only one endpoints in the collection: 

`/shout` To request quotes shouted

To use you need to ask for quotes of some person:

`/shout/steve-jobs?limit=2` To request two quotes from Steve Jobs

`/shout/albert-einstein?limit=1` To ask for one quote from Albert Einstein

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)
