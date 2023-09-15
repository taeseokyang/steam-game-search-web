import requests
from tkinter import *
from tkinter import messagebox
import pymysql
import time

ch = 0
# for h in range(2,7) :
def escape_s(s):
  s = "\\'".join(s.split("'")) 
  return s
# k = input()
# k = '\\"'.join(k.split('"'))
# k = "\\'".join(k.split("'"))
# print(k)
url = "https://steamspy.com/api.php?request=all&page=1"
data = requests.get(url).json()
key_list = []
for key in data:
    key_list.append(key)
for i in key_list[200:]:#처음부터 해야함!!!! 6p
  url = "https://steamspy.com/api.php?request=appdetails&appid="+str(i)
  data = requests.get(url).json()
  conn = pymysql.connect(host='127.0.0.1', user='root', password = 'password', db='myweb',charset='utf8')
  cur = conn.cursor()
  sql = ""
  try:
    p = data.get('positive')
    n = data.get('negative')
    if p==0 & n==0 :#평점 계산
      gpat = 0
    else :
      gpat = p/(p+n)*100
    if p==0 & n==0 :#평점 계산
      gpa = 0
    elif p<30:
      gpa = p/(p+n)*100
      if gpa>=70 :
        gpa = gpa - 30
    elif p<150:
      gpa = p/(p+n)*100
      if gpa>=70 :
        gpa = gpa - 15
    else :
      gpa = p/(p+n)*100
    keys=[]
    tags = data.get('tags')
    for key in tags:
      keys.append(key)
    keys_str = ", ".join(keys)
    sql = "INSERT INTO stm_game VALUES('"+str(data.get('appid'))+"','"+escape_s(data.get('name'))+"','"+escape_s(data.get('developer'))+"','"+escape_s(data.get('publisher'))+"','"+str(int(gpat))+"','"+str(int(gpa))+"','"+data.get('initialprice')+"','"+escape_s(data.get('languages'))+"','"+escape_s(keys_str)+"')"
    cur.execute(sql)
  except :
    sql = "SELECT COUNT(*) FROM stm_game where appid="+str(i)#이미 있는 데이터가 또있는 경우가 있음 
    cur.execute(sql)
    for k in cur :
      if k[0] == 1:
        print(key_list.index(i),"  already data -",i)
        time.sleep(1)
      else :
        messagebox.showerror('오류', '데이터 입력 오류가 발생함')
        print(key_list.index(i),"  err -",i)
        ch=1
    if ch == 1 :
      break
  else :
    # messagebox.showerror('성공', '데이터 입력 성공')
    print(key_list.index(i),"  ok -",i)
    conn.commit()
    conn.close()
    time.sleep(1)
# if ch == 1 : 
#   break