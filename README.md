# Web programming project Max Van Gastel 1849095

## Accounts

Aangezien de passwoorden van de users gehashed zijn, alle passwoorden behalve die van max is pw, die van max is pwmax
Login phpmyadmin: user admin pw W1no5kclEhod

## Setup
Er zit een docker.sh scriptje bij die werkt voor linux om de website op te zetten.
Dit zijn de commandos
<pre>
docker build -t projsitedocker .
docker run -p "8080:80" -v ${PWD}/codeigniter:/app -v ${PWD}/mysql:/var/lib/mysql projsitedocker
</pre>

## Redirects

Wanneer je de site niet op localhost wilt gebruiken moet je $baseurl in /codeigniter/app/config (line 26) aanpassen naar het ip van de pc die het host.

## Hosting

Wegens problemen met mySQL is het jammer genoeg enkel mogelijk om de site te hosten op linux (misschien ook op macos, dit kan ik niet testen).

## Accessibility

-No info is passed through colors  
-All pictures and videos have an alt-property explaining them  
-Forms have names and labels  
-Use of important info in heading tag  
-Website is completely usable with keyboard  
-Images are not used as links  
-Hierarchical usage of headers  
-Fluent design supporting multiple devices  
-Website is usable for people who disable javascript  