# AWS IP Blocker Script

This PHP script automatically fetches the latest AWS IP ranges from Amazon's public JSON file and updates `iptables` rules to block these IP addresses. It optionally uses Tor to anonymously fetch the JSON data.

## Prerequisites

- PHP CLI
- cURL support in PHP
- Tor (optional)
- `iptables`/`ip6tables`

## Installation

1. **Install Tor (Optional)**:
   - Tor is optional and is used for anonymous fetching of the JSON data. If you prefer not to use Tor, skip this step and modify the script to not use the Tor proxy.
   - If you choose to use Tor:
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
   - To run the script automatically once a day, you can set up a cron job. 
   - Edit the crontab for the root user with `sudo crontab -e`.
   - Add the following line to run the script every day at a specific time (e.g., at 3:00 AM):
     ```
     0 3 * * * /path/to/block_aws_ips.php
     ```

## How It Works

- The script fetches the latest set of IP ranges used by AWS services.
- If Tor is installed and configured, it uses Tor to anonymously fetch the JSON data.
- It parses the JSON file to extract both IPv4 and IPv6 ranges.
- For each IP range, the script checks if a corresponding rule already exists in `iptables`.
- If a rule does not exist, it adds a new rule to block traffic from that IP range.

## Caution

- Running this script will modify your `iptables` rules and can block a significant number of IP addresses.
- Ensure you understand the implications of running this script, as it might block legitimate traffic.
- It is highly recommended to test the script in a controlled environment before using it in production.

## License

This project is licensed under the MIT License - see the LICENSE file for details.
