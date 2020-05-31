## Evil Portals

![](https://img.shields.io/github/license/kbeflo/evilportals.svg?style=flat-square) 
[![HitCount](http://hits.dwyl.io/kbeflo/evilportals.svg)](http://hits.dwyl.io/kbeflo/evilportals) [![](https://img.shields.io/discord/413223793016963073.svg?style=flat-square)](https://discord.gg/Ka557WS)

[Evil Portals](https://github.com/kbeflo/evilportals) is a collection of portals that can be loaded into the Evil Portal module and can be used for phishing attacks against WiFi clients in order to obtain credentials or infect the victims with malware using the [Hak5](https://hak5.org/) [WiFi Pineapple](https://wifipineapple.com/) [Tetra](http://hakshop.myshopify.com/products/wifi-pineapple?variant=11303845317) and [Nano](http://hakshop.myshopify.com/products/wifi-pineapple?variant=81044992).

This project requires you to install [Evil Portal](https://github.com/frozenjava/EvilPortalNano) captive portal module created by [frozenjava](https://github.com/frozenjava). 

Install on the Pineapple, Modules -> Manage Modules -> Get Modules from WiFiPineapple.com -> Evil Portal 3.1. * 

*The Token Portals need EvilPortal version (4.B) that supports sendmail and tokens !

---

#### Usage

Clone the repository

	git clone https://github.com/kbeflo/evilportals

Change directory to evilportals/portals/

	cd evilportals/portals/

Copy the portals you wish to use on the Tetra at `/root/portals/` or on the Nano at `/sd/portals/`

    scp -r portal-login root@172.16.42.1:/root/portals/

Alternatively you can use [Filezilla](https://filezilla-project.org/) to copy the portals

	Host: sftp://172.16.42.1 Username: root Password: lamepassword Port: 22 

Finally on the WiFi Pineapple web interface, start the Evil Portal module and then activate the portal you wish to use.

After gathering credentials, captured data will be shown as a notification on the WiFi Pineapple web interface, and also stored on the Tetra at `/root/evilportal-logs/portal-login.txt` or on the Nano at `/sd/evilportal-logs/portal-login.txt` with additional profiling.

---
## Token Portals
Token Portals are Basic Portals with ability to generate tokens and send those via mail, those user based tokens will be request later to login.

### Token Portal Requirements:

--> smtp settings on your pinapple. (smtp server infos needed)

--> edit details of sender and subject of the mail in the MyPortal.php. (The sender and Subject for the user token mail)

--> if needed replace the template.html (email template with your own | the template needs to have a string "TOKEN" !)

#### Smtp Setup
You need to edit the /etc/ssmtp/ssmtp.conf and change it with your configuration.
For example, configuration for GMAIL (Less secure apps enabled):


root@Pineapple:/etc/ssmtp# cat ssmtp.conf
```
#
# /etc/ssmtp.conf -- a config file for sSMTP sendmail.
#
# The person who gets all mail for userids < 1000
# Make this empty to disable rewriting.
root=your_email@gmail.com

# The place where the mail goes. The actual machine name is required
# no MX records are consulted. Commonly mailhosts are named mail.domain.com
# The example will fit if you are in domain.com and your mailhub is so named.
mailhub=smtp.gmail.com:465

# Where will the mail seem to come from?
rewriteDomain=gmail.com

# The full hostname
hostname=mail.gmail.com

# Set this to never rewrite the "From:" line (unless not given) and to
# use that address in the "from line" of the envelope.
FromLineOverride=YES

# Use SSL/TLS to send secure messages to server.
UseTLS=YES
#UseSTARTTLS=Yes

AuthUser=your_email@gmail.com
AuthPass=your_gmail_password

# Use SSL/TLS certificate to authenticate against smtp host.
#UseTLSCert=YES

# Use this RSA certificate.
#TLSCert=/etc/ssl/certs/ssmtp.pem
```
---


#### Edit Email details matching your needs:
```
$sub = "Google FI - Your WIFI-Token !\nContent-Type: text/html"; //Subject of the mail & html format info just replace "Google FI - Your WIFI-Token !"
$sender = "your_email@gmail.com or your_fake_sender_email@gmail.com"; //Sender of the mail
```


#### Screenshots

<img src="https://user-images.githubusercontent.com/13497504/34363974-1b5e5f1e-eabc-11e7-99f5-78043f8b3ac9.png" width="200"/> <img src="https://user-images.githubusercontent.com/13497504/34363975-1d4b32ca-eabc-11e7-8532-2105a160c5c1.png" width="200"/> <img src="https://user-images.githubusercontent.com/13497504/34363977-1e8f4ca2-eabc-11e7-885e-e7dbd845e217.png" width="200"/>

<img src="https://user-images.githubusercontent.com/13497504/34363979-1f66e108-eabc-11e7-8dbb-39fa8b22c3a7.png" width="200"/> <img src="https://user-images.githubusercontent.com/13497504/34363982-20258324-eabc-11e7-93e0-b775fa1bcc25.png" width="200"/> <img src="https://user-images.githubusercontent.com/13497504/34366525-bba03dc4-ead7-11e7-8bea-a3fa9ae33ef4.png" width="200"/>

---

#### License
Evil Portals is distributed under the GNU GENERAL PUBLIC LICENSE v3. See [LICENSE](https://github.com/kbeflo/evilportals/blob/master/LICENSE) for more information.

#### Disclaimer
* Usage of Evil Portals for attacking infrastructures without prior mutual consistency can be considered as an illegal activity. It is the final user's responsibility to obey all applicable local, state and federal laws. Authors assume no liability and are not responsible for any misuse or damage caused by this program. 

---

Some of the portals here are also available for [Wifiphisher](https://github.com/wifiphisher/wifiphisher), available here [wifiphisher/extra-phishing-pages](https://github.com/wifiphisher/extra-phishing-pages)

Discussion thread - [Hak5 Forums](https://forums.hak5.org/index.php?/topic/39856-evil-portals/)

[Donate](https://paypal.me/kbeflo)

[Kleo Bercero](https://kbeflo.github.io/)
