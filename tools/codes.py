import random
import sqlite3 as lite
from sys import argv


class sql():
    __con = None
    __cur = None

    def close(self):
        sql.__con.close()

    def connect(self):
        sql.__con = lite.connect('web.db')
        sql.__cur = sql.__con.cursor()

    def insert(self, number):
        sql.__cur.execute('INSERT INTO codes(code) VALUES (?)', (number,))
        sql.__con.commit()

    def isnew(self, number):
        sql.__cur.execute('SELECT count(*) FROM codes WHERE code = ?', (number,))
        if(sql.__cur.fetchall() == 0):
            sql.__cur.execute('SELECT count(*) FROM users WHERE code = ?', (number,))
            if(sql.__cur.fetchall() == 0):
                return True
        return False


class rand():

    def randint(self):
        return random.randint(100000000000, 999999999999)

    def start(self):
        while True:
            number = rand().randint()
            if(not (sql().isnew(number))):
                break
        sql().insert(number)

if __name__ == '__main__':
    sql().connect()
    if len(argv) == 2:
        i = 0
        while (i < int(argv[1])):
            rand().start()
            i = i + 1
    else:
        rand().start()
    sql().close()
