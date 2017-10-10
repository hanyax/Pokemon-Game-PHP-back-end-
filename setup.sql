-- hw7 Pokemon table creation:
-- key an id number, and then strings representing
-- the password, username, and website:
CREATE TABLE IF NOT EXISTS Pokedex( 
    name VARCHAR(20) PRIMARY KEY,
    nickname VARCHAR(20),
    datefound DATETIME
);
