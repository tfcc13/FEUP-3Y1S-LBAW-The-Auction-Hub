DROP SCHEMA IF EXISTS lbaw24136 CASCADE;
CREATE SCHEMA IF NOT EXISTS lbaw24136;
SET search_path TO lbaw24136;

-- Drop Types if they exist
DROP TYPE IF EXISTS auction_state CASCADE;
DROP TYPE IF EXISTS user_state CASCADE;
DROP TYPE IF EXISTS notification_type CASCADE;
DROP TYPE IF EXISTS money_state CASCADE;
DROP TYPE IF EXISTS money_type CASCADE;
DROP TYPE IF EXISTS report_state CASCADE;

-- Drop Tables if they exist
DROP TABLE IF EXISTS report CASCADE;
DROP TABLE IF EXISTS user_image CASCADE;
DROP TABLE IF EXISTS auction_image CASCADE;
DROP TABLE IF EXISTS money_manager CASCADE;
DROP TABLE IF EXISTS notification CASCADE;
DROP TABLE IF EXISTS auction_winner CASCADE;
DROP TABLE IF EXISTS bid CASCADE;
DROP TABLE IF EXISTS auction_category CASCADE;
DROP TABLE IF EXISTS category CASCADE;
DROP TABLE IF EXISTS auction CASCADE;
DROP TABLE IF EXISTS address CASCADE;
DROP TABLE IF EXISTS users CASCADE;

-- Drop Indexes if they exist

DROP INDEX IF EXISTS  idx_auction_end_date;
DROP INDEX IF EXISTS  idx_auction_state;
DROP INDEX IF EXISTS  idx_auction_ts_vectors;
DROP INDEX IF EXISTS  idx_category_ts_vectors;
DROP INDEX IF EXISTS  idx_search_username;
DROP INDEX IF EXISTS  idx_user_view_status_date;
DROP INDEX IF EXISTS  idx_users_ts_vectors;

-- Drop Functions if they exist

DROP FUNCTION IF EXISTS category_fts_search;
DROP FUNCTION IF EXISTS username_fts_search;
DROP FUNCTION IF EXISTS auction_fts_search;
DROP FUNCTION IF EXISTS ensure_valid_bid;
DROP FUNCTION IF EXISTS check_user_balance_before_bid_trigger;
DROP FUNCTION IF EXISTS prevent_top_bidder_from_bidding_again;
DROP FUNCTION IF EXISTS extend_auction_on_new_bid;
DROP FUNCTION IF EXISTS prevent_banned_user_bid;
DROP FUNCTION IF EXISTS prevent_auction_edit_after_bid;
DROP FUNCTION IF EXISTS prevent_owner_follow;
DROP FUNCTION IF EXISTS ensure_bid_after_curr_bid;
DROP FUNCTION IF EXISTS prevent_owner_report;
DROP FUNCTION IF EXISTS ensure_auction_winner;
DROP FUNCTION IF EXISTS ensure_age_for_registration;
DROP FUNCTION IF EXISTS auction_notification;
DROP FUNCTION IF EXISTS notify_auction_report;
DROP FUNCTION IF EXISTS notify_owner_on_rating;
DROP FUNCTION IF EXISTS update_owner_rating;
DROP FUNCTION IF EXISTS prevent_admin_actions;
DROP FUNCTION IF EXISTS update_balances_on_auction_end;
DROP FUNCTION IF EXISTS anonymize_user_and_address;


-- Drop Triggers if they exist

DROP TRIGGER IF EXISTS username_fts_search_trigger ON users;
DROP TRIGGER IF EXISTS auction_fts_search_trigger ON auction;
DROP TRIGGER IF EXISTS category_fts_search_trigger ON category;
DROP TRIGGER IF EXISTS ensure_valid_bid_trigger ON bid;
DROP TRIGGER IF EXISTS check_user_balance_before_bid_trigger ON bid;
DROP TRIGGER IF EXISTS prevent_top_bidder_from_bidding_again_trigger ON bid;
DROP TRIGGER IF EXISTS extend_auction_on_new_bid_trigger ON auction;
DROP TRIGGER IF EXISTS prevent_banned_user_bid_trigger ON bid;
DROP TRIGGER IF EXISTS prevent_auction_edit_after_bid_trigger ON auction;
DROP TRIGGER IF EXISTS prevent_owner_bid_trigger ON bid;
DROP TRIGGER IF EXISTS prevent_owner_follow_trigger ON follow;
DROP TRIGGER IF EXISTS ensure_bid_after_curr_bid_trigger ON bid;
DROP TRIGGER IF EXISTS prevent_owner_report_trigger ON report;
DROP TRIGGER IF EXISTS ensure_auction_winner_trigger ON auction;
DROP TRIGGER IF EXISTS ensure_age_for_registration_trigger ON users;
DROP TRIGGER IF EXISTS auction_notification_trigger ON auction;
DROP TRIGGER IF EXISTS auction_report_notification_trigger ON auction;
DROP TRIGGER IF EXISTS notify_owner_on_rating_trigger ON rating;
DROP TRIGGER IF EXISTS update_owner_rating_trigger ON auction;
DROP TRIGGER IF EXISTS prevent_admin_bid_trigger ON bid;
DROP TRIGGER IF EXISTS prevent_admin_auction_creation_trigger ON auction;
DROP TRIGGER IF EXISTS auction_end_balance_update_trigger ON auction;
DROP TRIGGER IF EXISTS anonymize_user_and_address_trigger ON users;
DROP TRIGGER IF EXISTS trigger_set_default_end_date ON auction;




/***************** TYPES ******************** */


-- AuctionState Enum
CREATE TYPE auction_state AS ENUM ('Ongoing', 'Resumed', 'Canceled');

-- UserState Enum
CREATE TYPE user_state AS ENUM ('Active', 'Deleted', 'Banned');

-- NotificationType Enum
CREATE TYPE notification_type AS ENUM ('BidUpdate', 'AuctionUpdate', 'UserUpdate', 'RatingUpdate');

-- MoneyState Enum
CREATE TYPE money_state AS ENUM ('Pending', 'Approved', 'Denied');

-- MoneyType Enum
CREATE TYPE money_type AS ENUM ('Deposit', 'Withdraw', 'Transaction');

-- ReportState Enum
CREATE TYPE report_state AS ENUM ('Pending', 'Reviewed', 'Dismissed');


/***************** TABLES ******************** */


-- Users Table
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    username VARCHAR(255) UNIQUE NOT NULL,
    name VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    birth_date DATE NOT NULL CHECK (birth_date < CURRENT_DATE - INTERVAL '18 years'),
    credit_balance DECIMAL(12, 2) DEFAULT 0.00 NOT NULL,
    is_admin BOOLEAN DEFAULT FALSE,
    state user_state NOT NULL DEFAULT 'Active',
    rating FLOAT CHECK (rating >= 1 AND rating <= 5) DEFAULT NULL,
    remember_token VARCHAR(255) DEFAULT NULL, -- Column for storing the remember token
    description TEXT DEFAULT NULL -- Added description column
);

-- Address Table
CREATE TABLE address (
    id SERIAL PRIMARY KEY,
    street VARCHAR(255) NOT NULL,
    city VARCHAR(255) NOT NULL,
    district VARCHAR(255) NOT NULL,
    zip_code VARCHAR(20) NOT NULL,
    country VARCHAR(255) NOT NULL,
    user_id INT UNIQUE REFERENCES users(id) ON DELETE CASCADE
);

-- Categories Table
CREATE TABLE category (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) UNIQUE NOT NULL
);


-- Auctions Table
CREATE TABLE auction (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT DEFAULT NULL,
    start_price FLOAT CHECK (start_price >= 1000) NOT NULL,
    current_bid FLOAT DEFAULT NULL,
    start_date TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL,
    end_date TIMESTAMP DEFAULT NULL CHECK (end_date IS NULL OR end_date > start_date),
    state auction_state NOT NULL DEFAULT 'Ongoing',
    owner_id INT REFERENCES users(id) ON DELETE CASCADE,
    category_id INT REFERENCES category(id) ON DELETE SET NULL, 
    UNIQUE (title, owner_id)
);

-- User Images Table
CREATE TABLE user_image (
    id SERIAL PRIMARY KEY,
    path VARCHAR(255) DEFAULT '/images/default_profile_pic.jpg',
    user_id INT UNIQUE REFERENCES users(id) ON DELETE CASCADE,  
    UNIQUE (path)  
);


-- Auction Images Table
CREATE TABLE auction_image (
    id SERIAL PRIMARY KEY,
    path VARCHAR(255) NOT NULL,
    auction_id INT REFERENCES auction(id) ON DELETE CASCADE,
    UNIQUE (path, auction_id)
);


CREATE TABLE follows_auction (
    user_id INT REFERENCES users(id) ON DELETE CASCADE,     
    auction_id INT REFERENCES auction(id) ON DELETE CASCADE, 
    PRIMARY KEY (user_id, auction_id)                         
);



-- Bids Table
CREATE TABLE bid (
    id SERIAL PRIMARY KEY,
    auction_id INT REFERENCES auction(id) ON DELETE CASCADE,
    user_id INT REFERENCES users(id) ON DELETE CASCADE,
    amount FLOAT CHECK (amount > 1000) NOT NULL,
    bid_date TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL
);

-- Reports Table
CREATE TABLE report (
    user_id INT REFERENCES users(id) ON UPDATE CASCADE NOT NULL,
    auction_id INT REFERENCES auction(id) ON UPDATE CASCADE NOT NULL,
    description TEXT NOT NULL,
    view_status BOOLEAN DEFAULT FALSE NOT NULL,
    state report_state NOT NULL DEFAULT 'Pending',
    PRIMARY KEY (user_id, auction_id)
);



-- AuctionWinner Table
CREATE TABLE auction_winner (
    auction_id INT REFERENCES auction(id) ON UPDATE CASCADE NOT NULL,
    user_id INT REFERENCES users(id) ON UPDATE CASCADE NOT NULL,
    rating INT CHECK (rating BETWEEN 1 AND 5 OR NULL) DEFAULT NULL,
    PRIMARY KEY (auction_id, user_id)
);

-- Notifications Table
CREATE TABLE notification (
    id SERIAL PRIMARY KEY,
    content TEXT DEFAULT NULL,
    notification_date TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL,
    type notification_type NOT NULL,
    view_status BOOLEAN DEFAULT FALSE NOT NULL,
    user_id INT REFERENCES users(id) ON DELETE CASCADE,
    bid_id INT REFERENCES bid(id) ON DELETE CASCADE,
    report_user_id INT REFERENCES users(id) ON DELETE CASCADE,
    auction_id INT,
    CONSTRAINT fk_report FOREIGN KEY (report_user_id, auction_id) REFERENCES report(user_id, auction_id) ON DELETE CASCADE,
    CONSTRAINT only_one_reference CHECK (
        ((bid_id IS NOT NULL)::int + 
         (report_user_id IS NOT NULL AND auction_id IS NOT NULL)::int + 
         (auction_id IS NOT NULL AND bid_id IS NULL AND report_user_id IS NULL)::int) = 1
    )
);

-- MoneyManager Table
CREATE TABLE money_manager (
    id SERIAL PRIMARY KEY,
    amount FLOAT CHECK (amount > 0) NOT NULL,
    operation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    state money_state NOT NULL DEFAULT 'Pending',
    type money_type NOT NULL,
    user_id INT REFERENCES users(id) ON DELETE CASCADE,
    recipient_user_id INT REFERENCES users(id) ON DELETE SET NULL,
    CONSTRAINT valid_type_and_recipient CHECK (
        (type IN ('Deposit', 'Withdraw') AND  recipient_user_id IS NULL) OR 
        (type = 'Transaction' AND  recipient_user_id IS NOT NULL)
    )
);


/***************** INDEXES ******************** */

/* IDX01 */
CREATE INDEX idx_search_username on users USING HASH (username);

/* IDX02 */
CREATE INDEX idx_user_view_status_date ON notification (user_id, view_status, type, notification_date DESC); -- BTREE


/* IDX03 */
CREATE INDEX idx_auction_end_date ON auction (end_date);
CLUSTER auction USING idx_auction_end_date;


/* IDX04 - FTS - User fulltext search */

ALTER TABLE users
ADD COLUMN ts_vectors TSVECTOR;

CREATE FUNCTION username_fts_search() RETURNS TRIGGER AS $$
BEGIN
    IF TG_OP = 'INSERT' THEN
        NEW.ts_vectors = (
            setweight(to_tsvector('english', COALESCE(NEW.username, '')), 'A') ||
            setweight(to_tsvector('english', COALESCE(NEW.name, '')), 'B')
        );
    END IF;

    IF TG_OP = 'UPDATE' THEN
        IF NEW.username <> OLD.username OR NEW.name <> OLD.name THEN
            NEW.ts_vectors = (
                setweight(to_tsvector('english', COALESCE(NEW.username, '')), 'A') ||
                setweight(to_tsvector('english', COALESCE(NEW.name, '')), 'B')
            );
        END IF;
    END IF;

    RETURN NEW;
END
$$ LANGUAGE plpgsql;

CREATE TRIGGER username_fts_search_trigger
BEFORE INSERT OR UPDATE ON users
FOR EACH ROW
EXECUTE FUNCTION username_fts_search();


CREATE INDEX idx_users_ts_vectors ON users USING GIN(ts_vectors);


/* IDX05 - FTS - Auction fulltext search */

ALTER TABLE auction
ADD COLUMN ts_vectors TSVECTOR;

CREATE FUNCTION auction_fts_search() RETURNS TRIGGER AS $$
BEGIN
    IF TG_OP = 'INSERT' THEN
        NEW.ts_vectors = (
            setweight(to_tsvector('english', COALESCE(NEW.title, '')), 'A') ||
            setweight(to_tsvector('english', COALESCE(NEW.description, '')), 'B')
        );
    END IF;
    IF TG_OP = 'UPDATE' THEN
        IF NEW.title <> OLD.title OR NEW.description <> OLD.description THEN
            NEW.ts_vectors = (
                setweight(to_tsvector('english', COALESCE(NEW.title, '')), 'A') ||
                setweight(to_tsvector('english', COALESCE(NEW.description, '')), 'B')
            );
        END IF;
    END IF;

    RETURN NEW;
END
$$ LANGUAGE plpgsql;

CREATE TRIGGER auction_fts_search_trigger
BEFORE INSERT OR UPDATE ON auction
FOR EACH ROW
EXECUTE FUNCTION auction_fts_search();

CREATE INDEX idx_auction_ts_vectors ON auction USING GIN(ts_vectors);


/* IDX06 - FTS  - Category fulltext search */
ALTER TABLE category
ADD COLUMN ts_vectors TSVECTOR;


CREATE FUNCTION category_fts_search() RETURNS TRIGGER AS $$
BEGIN
    IF TG_OP = 'INSERT' THEN
        NEW.ts_vectors = setweight(to_tsvector('english', COALESCE(NEW.name, '')), 'A');
    END IF;

    IF TG_OP = 'UPDATE' THEN
        IF NEW.name <> OLD.name THEN
            NEW.ts_vectors = setweight(to_tsvector('english', COALESCE(NEW.name, '')), 'A');
        END IF;
    END IF;

    RETURN NEW;
END
$$ LANGUAGE plpgsql;

CREATE TRIGGER category_fts_search_trigger
BEFORE INSERT OR UPDATE ON category
FOR EACH ROW
EXECUTE FUNCTION category_fts_search();


CREATE INDEX idx_category_ts_vectors ON category USING GIN(ts_vectors);



/***************** TRIGGERS ******************** */


-- TRIGGER01
CREATE FUNCTION ensure_valid_bid() RETURNS TRIGGER AS $$
BEGIN
    IF NEW.amount <= (SELECT current_bid FROM auction WHERE id = NEW.auction_id) THEN
        RAISE EXCEPTION 'Bid must be higher than the current bid';
    END IF;
    RETURN NEW;
END
$$ LANGUAGE plpgsql;

CREATE TRIGGER ensure_valid_bid_trigger
BEFORE INSERT ON bid
FOR EACH ROW
EXECUTE FUNCTION ensure_valid_bid();


-- TRIGGER02
CREATE FUNCTION check_user_balance_before_bid() RETURNS TRIGGER AS $$
DECLARE
    user_balance DECIMAL(12, 2);
BEGIN
    SELECT credit_balance INTO user_balance
    FROM users
    WHERE id = NEW.user_id;

    IF user_balance < NEW.amount THEN
        RAISE EXCEPTION 'Insufficient balance: User does not have enough funds to place this bid';
    END IF;

    RETURN NEW;
END
$$ LANGUAGE plpgsql;


CREATE TRIGGER check_user_balance_before_bid_trigger
BEFORE INSERT ON bid
FOR EACH ROW
EXECUTE FUNCTION check_user_balance_before_bid();


-- TRIGGER03
CREATE FUNCTION prevent_top_bidder_from_bidding_again() RETURNS TRIGGER AS $$
BEGIN
    IF NEW.user_id = (SELECT user_id FROM bid WHERE auction_id = NEW.auction_id ORDER BY amount DESC LIMIT 1) THEN
        RAISE EXCEPTION 'Top bidder cannot place another bid';
    END IF;
    RETURN NEW;
END
$$ LANGUAGE plpgsql;

CREATE TRIGGER prevent_top_bidder_from_bidding_again_trigger
BEFORE INSERT ON bid
FOR EACH ROW
EXECUTE FUNCTION prevent_top_bidder_from_bidding_again();


-- TRIGGER04
CREATE FUNCTION extend_auction_on_new_bid() RETURNS TRIGGER AS $$
BEGIN
    IF NEW.bid_date > (SELECT end_date - INTERVAL '15 minutes' FROM auction WHERE id = NEW.auction_id) THEN
        UPDATE auction 
        SET end_date = end_date + INTERVAL '30 minutes' 
        WHERE id = NEW.auction_id;
    END IF;
    RETURN NEW;
END
$$ LANGUAGE plpgsql;


CREATE TRIGGER extend_auction_on_new_bid_trigger
AFTER INSERT ON bid
FOR EACH ROW
EXECUTE FUNCTION extend_auction_on_new_bid();


-- TRIGGER05
CREATE FUNCTION prevent_banned_user_bid() RETURNS TRIGGER AS $$
BEGIN
    IF (SELECT state FROM users WHERE id = NEW.user_id) = 'Banned' THEN
        RAISE EXCEPTION 'Banned users cannot place bids';
    END IF;
    RETURN NEW;
END
$$ LANGUAGE plpgsql;


CREATE TRIGGER prevent_banned_user_bid_trigger
BEFORE INSERT ON bid
FOR EACH ROW
EXECUTE FUNCTION prevent_banned_user_bid();


-- TRIGGER06
CREATE FUNCTION prevent_auction_edit_after_bid() RETURNS TRIGGER AS $$
BEGIN
    IF EXISTS (SELECT 1 FROM bid WHERE auction_id = NEW.id) THEN
        RAISE EXCEPTION 'Auction cannot be edited or canceled after a bid has been placed';
    END IF;
    RETURN NEW;
END
$$ LANGUAGE plpgsql;

CREATE TRIGGER prevent_auction_edit_after_bid_trigger
BEFORE UPDATE ON auction
FOR EACH ROW
EXECUTE FUNCTION prevent_auction_edit_after_bid();


-- TRIGGER07
CREATE FUNCTION prevent_owner_bid() RETURNS TRIGGER AS $$
BEGIN
    IF NEW.user_id = (SELECT owner_id FROM auction WHERE id = NEW.auction_id) THEN
        RAISE EXCEPTION 'Auction owners cannot bid on their own auctions';
    END IF;
    RETURN NEW;
END
$$ LANGUAGE plpgsql;

CREATE TRIGGER prevent_owner_bid_trigger
BEFORE INSERT ON bid
FOR EACH ROW
EXECUTE FUNCTION prevent_owner_bid();

-- TRIGGER08
CREATE FUNCTION prevent_owner_follow() RETURNS TRIGGER AS $$
BEGIN
    IF NEW.user_id = (SELECT owner_id FROM auction WHERE id = NEW.auction_id) THEN
        RAISE EXCEPTION 'Auction owners cannot follow their own auctions';
    END IF;
    RETURN NEW;
END
$$ LANGUAGE plpgsql;



CREATE TRIGGER prevent_owner_follow_trigger
BEFORE INSERT ON follows_auction
FOR EACH ROW
EXECUTE FUNCTION prevent_owner_follow();

-- TRIGGER09
CREATE FUNCTION ensure_bid_after_curr_bid() RETURNS TRIGGER AS $$
BEGIN
    IF NEW.bid_date <= (SELECT MAX(bid_date) FROM bid WHERE auction_id = NEW.auction_id) THEN
        RAISE EXCEPTION 'New bid must be after the current bid timestamp';
    END IF;
    RETURN NEW;
END
$$ LANGUAGE plpgsql;


CREATE TRIGGER ensure_bid_after_curr_bid_trigger
BEFORE INSERT ON bid
FOR EACH ROW
EXECUTE FUNCTION ensure_bid_after_curr_bid();


-- TRIGGER10
CREATE FUNCTION prevent_owner_report() RETURNS TRIGGER AS $$
BEGIN
    IF NEW.user_id = (SELECT owner_id FROM auction WHERE id = NEW.auction_id) THEN
        RAISE EXCEPTION 'Auction owners cannot report on their own auctions';
    END IF;
    RETURN NEW;
END
$$ LANGUAGE plpgsql;

CREATE TRIGGER prevent_owner_report_trigger
BEFORE INSERT ON report
FOR EACH ROW
EXECUTE FUNCTION prevent_owner_report();


-- TRIGGER11
CREATE FUNCTION ensure_auction_winner() RETURNS TRIGGER AS $$
BEGIN
    IF NEW.end_date <= CURRENT_TIMESTAMP THEN
        INSERT INTO auction_winner (auction_id, user_id)
        SELECT NEW.id, user_id FROM bid
        WHERE auction_id = NEW.id
        ORDER BY amount DESC LIMIT 1;
    END IF;
    RETURN NEW;
END
$$ LANGUAGE plpgsql;


CREATE TRIGGER ensure_auction_winner_trigger
AFTER UPDATE ON auction
FOR EACH ROW
EXECUTE FUNCTION ensure_auction_winner();


-- TRIGGER12
CREATE FUNCTION ensure_age_for_registration() RETURNS TRIGGER AS $$
BEGIN
    IF NEW.birth_date > CURRENT_DATE - INTERVAL '18 years' THEN
        RAISE EXCEPTION 'User must be at least 18 years old to register';
    END IF;
    RETURN NEW;
END
$$ LANGUAGE plpgsql;

CREATE TRIGGER ensure_age_for_registration_trigger
BEFORE INSERT ON users
FOR EACH ROW
EXECUTE FUNCTION ensure_age_for_registration();


-- TRIGGER13
CREATE FUNCTION auction_notification() RETURNS TRIGGER AS $$
BEGIN
    IF TG_OP = 'UPDATE' AND NEW.state IS DISTINCT FROM OLD.state THEN
        INSERT INTO notification (content, user_id, auction_id, type)
        VALUES (
            'The auction "' || NEW.title || '" has changed state to ' || NEW.state,
            NEW.owner_id,       
            NEW.id,
            'AuctionUpdate'
        );
    END IF;

    RETURN NEW;
END
$$ LANGUAGE plpgsql;


CREATE TRIGGER auction_notification_trigger
AFTER INSERT OR UPDATE ON auction
FOR EACH ROW
EXECUTE FUNCTION auction_notification();


-- TRIGGER14
CREATE FUNCTION notify_auction_report() RETURNS TRIGGER AS $$
DECLARE
    auction_owner INT;
BEGIN
    SELECT owner_id INTO auction_owner
    FROM auction
    WHERE id = NEW.auction_id;

    INSERT INTO notification (content, notification_date, type, view_status, user_id, report_user_id, auction_id)
    VALUES (
        'Your auction has been reported: ' || NEW.description,
        CURRENT_TIMESTAMP,
        'AuctionUpdate',
        FALSE,
        auction_owner,         
        NEW.user_id,           
        NEW.auction_id         
    );

    RETURN NEW;
END
$$ LANGUAGE plpgsql;

CREATE TRIGGER auction_report_notification_trigger
AFTER INSERT ON report
FOR EACH ROW
EXECUTE FUNCTION notify_auction_report();


-- TRIGGER15
CREATE FUNCTION notify_owner_on_rating() RETURNS TRIGGER AS $$
DECLARE
    auction_owner INT;
BEGIN
    SELECT owner_id INTO auction_owner
    FROM auction
    WHERE id = NEW.auction_id;

    INSERT INTO notification (content, notification_date, type, view_status, user_id, auction_id)
    VALUES (
        'You have received a new rating from the winner of your auction.',
        CURRENT_TIMESTAMP,
        'RatingUpdate',  
        FALSE,
        auction_owner,
        NEW.auction_id
    );

    RETURN NEW;
END
$$ LANGUAGE plpgsql;

CREATE TRIGGER notify_owner_on_rating_trigger
AFTER INSERT OR UPDATE OF rating ON auction_winner
FOR EACH ROW
WHEN (NEW.rating IS NOT NULL)  
EXECUTE FUNCTION notify_owner_on_rating();



-- TRIGGER16
CREATE FUNCTION update_owner_rating() RETURNS TRIGGER AS $$
DECLARE
    curr_owner_id INT;
    new_avg_rating FLOAT;
BEGIN

    SELECT owner_id INTO curr_owner_id
    FROM auction
    WHERE id = NEW.auction_id;


    SELECT ROUND(AVG(rating),1) INTO new_avg_rating
    FROM auction_winner
    WHERE auction_id IN (SELECT id FROM auction WHERE owner_id = curr_owner_id) 
          AND rating IS NOT NULL;


    UPDATE users
    SET rating = new_avg_rating
    WHERE id = curr_owner_id;

    RETURN NEW;
END
$$ LANGUAGE plpgsql;


CREATE TRIGGER update_owner_rating_trigger
AFTER INSERT OR UPDATE OF rating ON auction_winner
FOR EACH ROW
WHEN (NEW.rating IS NOT NULL) 
EXECUTE FUNCTION update_owner_rating();

-- TRIGGER17

CREATE FUNCTION prevent_admin_actions() RETURNS TRIGGER AS $$
DECLARE
    user_is_admin BOOLEAN;
BEGIN
    SELECT is_admin INTO user_is_admin
    FROM users
    WHERE id = NEW.id;

    IF user_is_admin THEN
        IF TG_TABLE_NAME = 'bid' THEN
            RAISE EXCEPTION 'Admin users are not allowed to place bids';
        ELSIF TG_TABLE_NAME = 'auction' THEN
            RAISE EXCEPTION 'Admin users are not allowed to create auctions';
        END IF;
    END IF;

    RETURN NEW;
END
$$ LANGUAGE plpgsql;


CREATE TRIGGER prevent_admin_bid_trigger
BEFORE INSERT ON bid
FOR EACH ROW
EXECUTE FUNCTION prevent_admin_actions();

CREATE TRIGGER prevent_admin_auction_creation_trigger
BEFORE INSERT ON auction
FOR EACH ROW
EXECUTE FUNCTION prevent_admin_actions();


-- TRIGGER18
CREATE FUNCTION update_balances_on_auction_end() RETURNS TRIGGER AS $$
DECLARE
    winner_balance DECIMAL(12, 2);
    owner_balance DECIMAL(12, 2);
    bid_amount DECIMAL(12, 2);
BEGIN
    IF NEW.state = 'Resumed' THEN
        SELECT amount INTO bid_amount
        FROM bid
        WHERE auction_id = NEW.id
        ORDER BY bid_date DESC
        LIMIT 1;

        SELECT credit_balance INTO winner_balance
        FROM users
        WHERE id = (SELECT user_id FROM bid WHERE auction_id = NEW.id ORDER BY bid_date DESC LIMIT 1);
        
        SELECT credit_balance INTO owner_balance
        FROM users
        WHERE id = NEW.owner_id;

        UPDATE users SET credit_balance = winner_balance - bid_amount
        WHERE id = (SELECT user_id FROM bid WHERE auction_id = NEW.id ORDER BY bid_date DESC LIMIT 1);

        UPDATE users SET credit_balance = owner_balance + bid_amount
        WHERE id = NEW.owner_id;


    END IF;

    RETURN NEW;
END
$$ LANGUAGE plpgsql;


CREATE TRIGGER auction_end_balance_update_trigger
AFTER UPDATE ON auction
FOR EACH ROW
WHEN (NEW.state = 'Resumed')
EXECUTE FUNCTION update_balances_on_auction_end();



-- TRIGGER19
CREATE OR REPLACE FUNCTION anonymize_user_and_address() RETURNS TRIGGER AS
$$
BEGIN

  IF NEW.state = 'Deleted' THEN

    NEW.username := 'anonymous' || OLD.id;
    NEW.name := 'Anonymous';
    NEW.email := 'anonymous' || OLD.id || '@theauctionhub.com';
    NEW.password := 'anonymous';
    NEW.birth_date := '1900-01-01';
    NEW.credit_balance := 0.00;
    NEW.rating := NULL;
    
    UPDATE address 
    SET 
      street = 'Anonymous Street',
      city = 'Anytown',
      district = 'Any District',
      zip_code = '00000',
      country = 'Unknown'
    WHERE user_id = OLD.id;
  END IF;

  RETURN NEW;
END;
$$ LANGUAGE plpgsql;


CREATE TRIGGER anonymize_user_and_address_trigger
BEFORE UPDATE ON users
FOR EACH ROW
EXECUTE FUNCTION anonymize_user_and_address();

--TRIGGER 20
CREATE OR REPLACE FUNCTION set_default_end_date()
RETURNS TRIGGER AS $$
BEGIN
    -- If end_date is not provided, set it to 30 days after start_date
    IF NEW.end_date IS NULL THEN
        NEW.end_date := NEW.start_date + INTERVAL '30 days';
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_set_default_end_date
BEFORE INSERT ON auction
FOR EACH ROW
EXECUTE FUNCTION set_default_end_date();
