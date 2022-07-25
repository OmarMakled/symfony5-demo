## Installation

```
  make run && make install
```

## Run commands inside the container

```
  make enter
```

## Run tests

```
  make test
```

```
Import Logs Command (App\Tests\Functional\Controller\ImportLogsCommand)
 ✔ Import all logs
 ✔ Import logs from

Api Controller (App\Tests\Functional\Controller\ApiController)
 ✔ Get count on success
 ✔ Get count bad input parameter

Health Check Controller (Tests\Functional\Controller\HealthCheckController)
 ✔ Health z endpoint

Log Request (Tests\Unit\Request\LogRequest)
 ✔ Get service names
 ✔ Get status code
 ✔ Get start and end date

Log Parser (Tests\Unit\Service\LogParser)
 ✔ Get service
 ✔ Get date
 ✔ Get request
 ✔ Parse
 ✔ Fill

Log Reader (Tests\Unit\Service\LogReader)
 ✔ Open wrong file
 ✔ Open and read
 ✔ Open and read offset

Time: 00:03.921, Memory: 30.00 MB

OK (16 tests, 42 assertions)
```

## Import logs file

```
./bin/console app:import logs.txt
./bin/console app:import logs.txt 2 // Import from specific line
```

## Api

`GET http://localhost:9002/count`

| Param         | Type     | Example | Required |
|--------------|-----------|------------|------------| 
| startDate | string     |  startDate=2021-08-17 09:21:53     | optional
| endDate | string     |  endDate=2021-08-17 09:21:53     | optional
| statusCode | int     |  statusCode=200     | optional
| serviceNames | string, array     |  serviceNames=foo,bar  serviceNames[]=foo&servicesName[]=bar   | optional

**Success 200**
```
{
  "counter": 0
}
```

**Invalid parameter 400**
"bad input parameter"

Happy Code!
