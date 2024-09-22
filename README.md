# Laravel vs Symfony Performance Comparison

This project compares the performance of Laravel and Symfony frameworks using Docker containers.

## How to start

### Prerequisites
- Docker and Docker Compose installed on your system
- Make utility

### Setup and Run Tests

1. Clone the repository and navigate to the project directory.

2. Build and start the Docker containers:
   ```bash
    make install
   ```
   This command will build the Docker containers and install the dependencies for Laravel and Symfony projects.

3. Run the performance tests:

   For Laravel:
   ```bash
    make laravel-check
   ```

   For Symfony:
   ```bash
    make symfony-check
   ```

## Test Results

### Laravel

```
Average time: 19.374376 ms
Average memory: 0.00 KB
```

### Symfony

```
Average time: 0.033785 ms
Average memory: 0.00 KB
```

## Project Structure

- `laravel/` - Laravel project directory
- `symfony/` - Symfony project directory
- `docker-compose.entrance.yml` - Main Docker Compose configuration
- `Makefile` - Contains commands for building, running, and testing

## Notes

- The tests measure the time and memory usage for creating instances of `RootService` and `RootService2`.
- Each test is run 200 times and the average is calculated.

## References

- [Container Efficiency in Modular Monoliths: Symfony vs. Laravel](https://sarvendev.com/2024/07/container-efficiency-in-modular-monoliths-symfony-vs-laravel/)
- [Uncovering the bottlenecks: An investigation into the poor performance of Laravel’s container](https://sarvendev.com/2023/04/uncovering-the-bottlenecks-an-investigation-into-the-poor-performance-of-laravels-container/)