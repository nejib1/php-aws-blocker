# AWS IP Blocker Script

If you are like me, you might find yourself bombarded by unwanted traffic and requests originating from Amazon Compute resources. To address this, I created a PHP script that automatically fetches the latest AWS IP ranges from Amazon's public JSON file and updates `iptables` rules to block these IP addresses. The script optionally uses Tor for anonymous data fetching.

## Prerequisites

- PHP CLI
- cURL support in PHP
- Tor (optional)
- `iptables`/`ip6tables`

## Installation

1. **Install Tor (Optional)**:
   - Using Tor is optional and it's used for anonymously fetching the JSON data. If you prefer not to use Tor, simply skip this step and modify the script to not use the Tor proxy.
   - If opting to use Tor:
     - Debian/Ubuntu: `sudo apt-get install tor`
     - CentOS/RedHat: `sudo yum install tor`
     - macOS (using Homebrew): `brew install tor`
   - Start the Tor service on Linux: `sudo service tor start`
   - Ensure Tor is configured to listen on port 9050 (SOCKS proxy).

2. **Clone the Repository**:
   - Clone this repository or download the script to your server.

## Usage

1. **Make the Script Executable**:
   - Run `chmod +x block_aws_ips.php` to make the script executable.

2. **Run the Script**:
   - Execute the script with `sudo ./block_aws_ips.php`.

3. **Optional: Set Up a Cron Job**:
   - For automatic daily execution, set up a cron job. 
   - Edit the crontab for the root user with `sudo crontab -e`.
   - Add the following line to run the script every day at a specific time (e.g., 3:00 AM):
     ```
     0 3 * * * /path/to/block_aws_ips.php
     ```

## How It Works

- The script fetches the latest IP ranges used by AWS services.
- It uses Tor, if installed and configured, to anonymously retrieve the JSON data.
- It then parses the JSON file to extract both IPv4 and IPv6 ranges.
- The script checks if each IP range already has a corresponding rule in `iptables`.
- New rules are added only for IP ranges not already blocked.

## Caution

- This script modifies `iptables` rules and may block a significant number of IP addresses.
- Understand the implications, as this might block legitimate traffic.
- Testing in a controlled environment before using it in production is highly recommended.

## License

This project is licensed under the MIT License - see the LICENSE file for details.
