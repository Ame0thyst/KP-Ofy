https://fontawesome.com/

<!-- Hapus Trigger -->
DROP TRIGGER IF EXISTS after_insert_author_login;
DROP TRIGGER IF EXISTS after_update_author_login;
DROP TRIGGER IF EXISTS after_delete_author_login;

<!-- Trigger Insert -->
DELIMITER $$
CREATE TRIGGER after_insert_author_login
AFTER INSERT ON author_login
FOR EACH ROW
BEGIN
  INSERT INTO authors (id, name, email, phone)
  VALUES (NEW.id, NEW.name, NEW.email, NEW.phone);
END$$
DELIMITER ;

<!-- Trigger Update  -->
DELIMITER $$
CREATE TRIGGER after_update_author_login
AFTER UPDATE ON author_login
FOR EACH ROW
BEGIN
  UPDATE authors
  SET name = NEW.name,
      email = NEW.email,
      phone = NEW.phone
  WHERE id = NEW.id;
END$$
DELIMITER ;

<!-- Trigger Delete -->
DELIMITER $$
CREATE TRIGGER after_delete_author_login
AFTER DELETE ON author_login
FOR EACH ROW
BEGIN
  DELETE FROM authors WHERE id = OLD.id;
END$$
DELIMITER ;