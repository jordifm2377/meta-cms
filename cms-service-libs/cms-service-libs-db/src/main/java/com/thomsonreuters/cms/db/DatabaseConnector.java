package com.thomsonreuters.cms.db;

import java.sql.SQLException;

public interface DatabaseConnector {
	
    public DatabaseExecutor getDatabaseExecutor(boolean autoCommit) throws SQLException;
	public String getSchema();
}
