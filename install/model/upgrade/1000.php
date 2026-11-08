<?php
class ModelUpgrade1000 extends Model {
	public function upgrade() {
		$file = DIR_APPLICATION . 'opencart.sql';

		if (!file_exists($file)) {
			exit('Could not load sql file: ' . $file);
		}

		$lines = file($file);
		if (!$lines) {
			return;
		}

		$create_tables = array();
		$insert_statements = array();

		$sql = '';
		foreach ($lines as $line) {
			if ($line && (substr($line, 0, 2) != '--') && (substr($line, 0, 1) != '#')) {
				$sql .= $line;

				if (preg_match('/;\s*$/', $line)) {
					$trimmed = trim($sql);

					if (preg_match('/^CREATE\s+TABLE\s+(?:IF\s+NOT\s+EXISTS\s+)?`oc_([^`]+)`/i', $trimmed, $m)) {
						$raw_table = $m[1];
						$table_name = DB_PREFIX . $raw_table;
						$stmt = preg_replace('/^CREATE\s+TABLE\s+(?:IF\s+NOT\s+EXISTS\s+)?`oc_([^`]+)`/i', 'CREATE TABLE IF NOT EXISTS `' . $table_name . '`', $trimmed);
						$create_tables[$table_name] = $stmt;
					} elseif (preg_match('/^INSERT\s+INTO\s+`oc_([^`]+)`/i', $trimmed, $m)) {
						$raw_table = $m[1];
						$table_name = DB_PREFIX . $raw_table;
						$stmt = preg_replace('/^INSERT\s+INTO\s+`oc_([^`]+)`/i', 'INSERT INTO `' . $table_name . '`', $trimmed);
						if (!isset($insert_statements[$table_name])) {
							$insert_statements[$table_name] = array();
						}
						$insert_statements[$table_name][] = $stmt;
					}

					$sql = '';
				}
			}
		}

		// Get existing tables in the database
		$existing_tables = array();
		$table_query = $this->db->query("SHOW TABLES FROM `" . DB_DATABASE . "`");
		foreach ($table_query->rows as $row) {
			$tbl = reset($row);
			if ($tbl) {
				$existing_tables[$tbl] = true;
			}
		}

		foreach ($create_tables as $table_name => $create_sql) {
			if (!isset($existing_tables[$table_name])) {
				// Table does not exist: create it and run its seed inserts
				$this->db->query($create_sql);

				if (!empty($insert_statements[$table_name])) {
					foreach ($insert_statements[$table_name] as $insert_sql) {
						$this->db->query($insert_sql);
					}
				}
				continue;
			}

			// Table exists: inspect existing columns and indexes
			$existing_columns = array();
			$col_query = $this->db->query("SHOW COLUMNS FROM `" . $table_name . "`");
			foreach ($col_query->rows as $col_row) {
				$existing_columns[$col_row['Field']] = $col_row;
			}

			$existing_indexes = array();
			$idx_query = $this->db->query("SHOW INDEX FROM `" . $table_name . "`");
			foreach ($idx_query->rows as $idx_row) {
				$existing_indexes[$idx_row['Key_name']] = true;
			}

			$stmt_lines = explode("\n", $create_sql);
			$prev_col = '';

			foreach ($stmt_lines as $sline) {
				$sline = trim($sline);

				if (!$sline || stripos($sline, 'CREATE TABLE') === 0 || substr($sline, 0, 1) === ')') {
					continue;
				}

				// Column definition
				if (substr($sline, 0, 1) === '`') {
					if (preg_match('/^`([^`]+)`\s+(.+?)\s*,?$/', $sline, $cm)) {
						$col_name = $cm[1];
						$col_def = $cm[2];

						if (!isset($existing_columns[$col_name])) {
							$position = $prev_col ? " AFTER `" . $prev_col . "`" : " FIRST";
							$this->db->query("ALTER TABLE `" . $table_name . "` ADD `" . $col_name . "` " . $col_def . $position);
							$existing_columns[$col_name] = true;
						}

						$prev_col = $col_name;
					}
				} elseif (preg_match('/^PRIMARY\s+KEY\s*\((.+)\)\s*,?$/i', $sline, $pm)) {
					if (!isset($existing_indexes['PRIMARY'])) {
						$this->db->query("ALTER TABLE `" . $table_name . "` ADD PRIMARY KEY (" . $pm[1] . ")");
						$existing_indexes['PRIMARY'] = true;
					}
				} elseif (preg_match('/^(UNIQUE\s+)?KEY\s+`([^`]+)`\s*\((.+)\)\s*,?$/i', $sline, $km)) {
					$is_unique = !empty($km[1]);
					$idx_name = $km[2];
					$idx_cols = $km[3];

					if (!isset($existing_indexes[$idx_name])) {
						$idx_type = $is_unique ? 'UNIQUE KEY' : 'KEY';
						$this->db->query("ALTER TABLE `" . $table_name . "` ADD " . $idx_type . " `" . $idx_name . "` (" . $idx_cols . ")");
						$existing_indexes[$idx_name] = true;
					}
				}
			}

			// If an existing seed table is completely empty, populate its default rows
			if (!empty($insert_statements[$table_name])) {
				$cnt_query = $this->db->query("SELECT COUNT(*) AS total FROM `" . $table_name . "`");
				if ((int)$cnt_query->row['total'] === 0) {
					foreach ($insert_statements[$table_name] as $insert_sql) {
						$this->db->query($insert_sql);
					}
				}
			}
		}
	}
}
