# AWS IP Blocker Script

![AWS IP Blocker](https://i.imgur.com/8z60Lxx.png)

If you're experiencing the same issues as I have, you might find that your server is constantly bombarded with unwanted traffic and requests coming from Amazon Compute resources. 
To tackle this problem, I developed a PHP script that automatically retrieves the latest AWS IP ranges from Amazon's public JSON file.
The script then updates the `iptables`  rules to <span style="text-decoration: underline;">**block**</span>
 these IP addresses.

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
   - Run `chmod +x aws-blocker.php` to make the script executable.

2. **Run the Script**:
   - Execute the script with `sudo ./aws-blocker.php`.

3. **Optional: Set Up a Cron Job**:
   - For automatic daily execution, set up a cron job. 
   - Edit the crontab for the root user with `sudo crontab -e`.
   - Add the following line to run the script every day at a specific time (e.g., 3:00 AM):
     ```
     0 3 * * * /path/to/aws-blocker.php
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

## Author

**Nejib BEN AHMED**

## License

This project is licensed under the MIT License - see the LICENSE file for details.
