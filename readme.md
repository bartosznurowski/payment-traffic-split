# Payment Traffic Splitting

This project implements the `TrafficSplit` class, which distributes payment traffic to different payment gateways according to defined percentage weights.  
Example usage: distributing load among multiple gateways in proportions such as 75%, 10%, 15%, or evenly 25%, 25%, 25%, 25%.

---

## Technologies

- PHP 8.2+
- Symfony 7.3.2
- PHPUnit for unit testing

---

## Installation

1. Clone the repository:

git clone https://github.com/bartosznurowski/payment-traffic-split

2. Navigate to the project folder:

cd payment-traffic-split

3. Install dependencies:

composer install

4. Run unit tests:

php bin/phpunit