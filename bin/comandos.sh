    1  sudo locale-gen en_US
    2  clear
    3  sudo apt-get -y update
    4  sudo apt-get install -y python-software-properties
    5  sudo add-apt-repository -y ppa:ondrej/php5-5.6
    6  sudo apt-get -y update
    7  sudo apt-get -y install php5 php5-mhash php5-mcrypt php5-curl php5-cli php5-mysql php5-gd php5-intl php5-xsl php5-bcmath php5-odbc libapache2-mod-php5 freetds-bin freetds-common
    8  sudo apt-get -y install php5 php5-mcrypt php5-curl php5-cli php5-mysql php5-gd php5-intl php5-xsl php5-odbc libapache2-mod-php5 freetds-bin freetds-common 
    9  service apache2 start
   10  cd /var/www/html/
   11  ls
   12  vim index.html 
   13  sudo apt-get -y vim
   14  sudo apt-get -y install vim
   15  vim index.html 
   16  sudo vim index.html 
   17  clear
   18  cd /var/www/html/
   19  sudo vim teste.php
   20  sudo apt-get install freetds-bin freetds-common 
   21  cd /
   22  find | grep freetds
   23  clear
   24  sudo find | grep freetds
   25  vim /etc/freetds/freetds.conf 
   26  sudo vim /etc/freetds/freetds.conf 
   27  service apache2 restart 
   28  sudo service apache2 restart 
   29  clear
   30  cd /etc/apache2/
   31  ls
   32  cd sites-available/
   33  ls
   34  sudo vim 000-default.conf 
   35  ls
   36  sudo vim default-ssl.conf 
   37  ls
   38  cd ..
   39  ls
   40  vim ports.conf 
   41  cd conf-
   42  clear
   43  ls
   44  clear
   45  ls
   46  cd sites-enabled/
   47  ls
   48  sudo vim 000-default.conf 
   49  sudo service apache2 restart
   50  cp /var/www/html/teste.php /vagrant/
   51  sudo cp /var/www/html/teste.php /vagrant/
   52  cd /vagrant/
   53  ls
   54  celar
   55  ls
   56  sudo cm teste.php index.php
   57  sudo cp teste.php index.php
   58  ls
   59  sudo chmod /vagrant/
   60  sudo chmod 777 /vagrant/
   61  service apache2 restart
   62  sudo service apache2 restart
   63  cd /etc/apache2/
   64  ls
   65  sudo vim sites-enabled/
   66  cd sites-enabled/
   67  ls
   68  sudo vim 000-default.conf 
   69  ls
   70  cd ..
   71  ls
   72  cd sites-available/
   73  ls
   74  sudo vim 000-default.conf 
   75  ls
   76  sudo vim default-ssl.conf 
   77  ls
   78  cd ..
   79  ls
   80  sudo vim ports.conf 
   81  sudo vim apache2.conf 
   82  sudo service apache2 restart
   83  ls
   84  cd sites-available/
   85  ls
   86  sudo vim 000-default.conf 
   87  sudo vim default-ssl.conf 
   88  sudo service apache2 restart
   89  ls
   90  cd ..
   91  ls
   92  cd sites-enabled/
   93  ls
   94  sudo vim 000-default.conf 
   95  ls
   96  cd ..
   97  ls
   98  cd sites-available/
   99  ls
  100  sudo su
  101  ls
  102  sudo cp /etc/php5/apache2/php.ini /vagrant/
  103  cd /vagrant/
  104  ls
  105  clear
  106  sudo apt-get install php5-odbc 
  107  sudo apt-get install php5-json 
  108  sudo apt-get install php5-sybase 
  109  sudo service apache2 restart
  110  clear
  111  vim /etc/apache2/apache2.conf 
  112  vim /etc/apache2/conf-available/
  113  vim /etc/apache2/conf-enabled/charset.conf 
  114  sudo vim /etc/apache2/conf-enabled/charset.conf 
  115  cd /etc/freetds/
  116  ls
  117  sudo vim locales.conf
  118  sudo cp locales.conf /etc/
  119  ls
  120  cd ..
  121  vim locales.conf 
  122  clear
  123  cd /etc/
  124  ls
  125  clear
  126  vim locales.conf
  127  vim freetds/freetds.conf 
  128  sudo vim freetds/freetds.conf 
  129  service apache2 restart 
  130  sudo service apache2 restart 
  131  clear
  132  cd /etc/apache2/
  133  ls
  134  vim conf-enabled/
  135  clear
  136  ls
  137  cd cd conf-enabled/
  138  ls
  139  vim apache2.conf 
  140  sudo a2enmod rewrite
  141  service apache2 restart 
  142  sudo service apache2 restart 
  143  ls
  144  cd sites-available/
  145  ls
  146  vim 000-default.conf 
  147  ls
  148  cd ..
  149  ls
  150  cd sites-enabled/
  151  ls
  152  vim 000-default.conf 
  153  ls
  154  cd ..
  155  ls
  156  vim ports.conf 
  157  cd mods-enabled/
  158  ls
  159  cd ..
  160  cd mods-available/
  161  ls
  162  cd ..
  163  ls
  164  cd mods-enabled/
  165  ls
  166  cd ..
  167  ls
  168  vim apache2.conf 
  169  sudo vim apache2.conf 
  170  service apache2 restart 
  171  sudo service apache2 restart 
  172  clear
  173  los
  174  ls
  175  clear
  176  cd /
  177  sudo find | grep phpunit
  178  clear
  179  ls
  180  sudo find /etc/ | grep phpunit
  181  sudo find /srv/ | grep phpunit
  182  wget https://phar.phpunit.de/phpunit.phar
  183  sudo wget https://phar.phpunit.de/phpunit.phar
  184  chmod +x phpunit.phar
  185  sudo chmod +x phpunit.phar
  186  sudo mv phpunit.phar /usr/local/bin/phpunit
  187  phpunit --version
  188  /usr/local/bin/phpunit 
  