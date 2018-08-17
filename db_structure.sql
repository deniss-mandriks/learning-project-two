CREATE TABLE IF NOT EXISTS "product_types" (
  "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
  "name" VARCHAR NOT NULL UNIQUE,
  "price_per_day" REAL,
  "price_per_hour" REAL,
  "price_per_item" REAL
);

CREATE TABLE IF NOT EXISTS "products" (
  "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
  "name" VARCHAR NOT NULL,
  "product_types_id" INTEGER NOT NULL,
  FOREIGN KEY ("product_types_id") REFERENCES product_types("id")
);

CREATE TABLE IF NOT EXISTS "users" (
  "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
  "name" VARCHAR NOT NULL,
  "password" VARCHAR NOT NULL
);

CREATE TABLE IF NOT EXISTS "quote_attributes" (
  "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
  "start_date" TEXT,
  "end_date" TEXT,
  "start_time" TEXT,
  "end_time" TEXT,
  "day_of_week" VARCHAR,
  "week_count" INTEGER,
  "quantity" INTEGER
);

CREATE TABLE IF NOT EXISTS "quotes" (
  "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
  "product_id" INTEGER NOT NULL,
  "quote_attributes_id" INTEGER NOT NULL,
  "user_id" INTEGER NOT NULL,
  "phone_number" VARCHAR,
  FOREIGN KEY ("product_id") REFERENCES products("id"),
  FOREIGN KEY ("quote_attributes_id") REFERENCES  quote_attributes("id"),
  FOREIGN KEY ("user_id") REFERENCES users("id")
);

INSERT INTO products (name, product_types_id)
VALUES ('PHP Course', 1);

INSERT INTO products (name, product_types_id)
VALUES ('Additional PHP lessons', 2);

INSERT INTO products (name, product_types_id)
VALUES ('Dune by Frank Herbert', 3);

INSERT INTO product_types (id, name, price_per_day, price_per_hour, price_per_item)
VALUES (1, 'Subscription', 1.23, NULL, NULL);

INSERT INTO product_types (id, name, price_per_day, price_per_hour, price_per_item)
VALUES (2, 'Services', NULL, 2.34, NULL);

INSERT INTO product_types (id, name, price_per_day, price_per_hour, price_per_item)
VALUES (3, 'Goods', NULL, NULL, 3.45);