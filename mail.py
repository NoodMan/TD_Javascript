import smtplib

server = smtplib.SMTP_SSL('smtp-pawolanmwen.alwaysdata.net', 465)
server.login("sandbox@loryleticee.com", "myqTem-0dejnu-wytwaw")
server.sendmail (
    "sandbox@loryleticee.com",
    "camara.adeline@yahoo.fr",
    "subject : Nouvelle image disponible sur le serveur \n Ce message vient de python. Bla bla bla STOP.")
server.quit()
