CREATE TABLE {$NAMESPACE}_search.search_indexversion (
  id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  objectPHID VARBINARY(64) NOT NULL,
  extensionKey VARCHAR(64) NOT NULL COLLATE {$COLLATE_TEXT},
  version VARCHAR(128) NOT NULL COLLATE {$COLLATE_TEXT},
  UNIQUE KEY `key_object` (objectPHID, extensionKey)
) ENGINE=InnoDB, COLLATE {$COLLATE_TEXT};
