import sqlite3
import pandas as pd

df = pd.read_csv('data.csv')

df.columns = df.columns.str.strip()

connection = sqlite3.connect('gdp.db')

df.to_sql('gdp', connection, if_exists='replace')
