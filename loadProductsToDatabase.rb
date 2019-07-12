require 'nokogiri'
require 'rest-client'
require "mysql2"
require 'open-uri'

@db_host  = "localhost"
@db_user  = "root"
@db_pass  = ""
@db_name = "sklep"

$client = Mysql2::Client.new(:host => @db_host , :username => @db_user, :password => @db_pass, :database =>@db_name)

url = 'http://konsoleigry.pl'

#download = open('http://konsoleigry.pl/62556-listaprod_default/ark-survival-evolved-pc-pl.jpg')
#IO.copy_stream(download, 'ark-survival-evolved-pc-pl.jpg')

html = RestClient.get(url)
doc = Nokogiri::HTML.parse(html)
categories = doc.css('.menu-content > p > a')

links = []
i = 0

def getProducts(html, categoryid)
  products = html.css('.product-container');

  products.each do |product|

  #  $client.query("insert into games values (NULL, \""+product.css('.name > a').text.to_s+"\",
  #   "+product.css('.price').text.sub!(' zł', '').sub!(',', '.').to_s+", \"\", 5, "+categoryid.to_s+", \""+product.css('img').attr('data-original').to_s.split('/').last+"\", NULL)")

  #   download = open(product.css('img').attr('data-original'))
  #   IO.copy_stream(download, "D:/Programy/XAMPP/htdocs/Sklep/E-Shop/images/"+product.css('img').attr('data-original').to_s.split('/').last)
  end
end

categories.each do |category|
  values = []
  if ((category["href"].include? "x360") && (!category["href"].include? "klucze") && (!category.text.include? "DLC") && (!category.text.include? "Akcesoria"))
    result = $client.query("SELECT COUNT(*) as ilosc FROM categories WHERE NAME =\""+category.text.sub!("Gry","").to_s+"\"")
    values.push(category["href"])
    i+=1
    if((result.first["ilosc"]) == 0)
      puts category.text
      $client.query("insert into categories values(NULL,\""+(category.text.sub!("Gry","")).to_s+"\", NULL)")
    end
    result = $client.query("SELECT CATEGORY_ID FROM categories WHERE NAME =\""+category.text.sub!("Gry","").to_s+"\"")
    values.push(result.first['CATEGORY_ID'])
  end
  if(values.any?)
    links.push(values)
  end
end

$i=0

links.each do |link|
  getLink = link[0].split('/')
  puts getLink[2]
  puts "Please wait..."
  html = RestClient.get(url + '/' + (getLink[1].sub!('#',"").to_s) + '?selected_filters=' +getLink.last)
  doc = Nokogiri::HTML.parse(html)

  getProducts(doc, link[1])

  while a = doc.css('.pagination_next > a').first
    href = a["href"]
    html = RestClient.get(url+href)
    doc = Nokogiri::HTML.parse(html)
    getProducts(doc, link[1])
  end
  puts 'Success'
  $i+=1
end

gets
