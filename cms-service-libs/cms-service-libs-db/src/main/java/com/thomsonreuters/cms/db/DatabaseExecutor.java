package com.thomsonreuters.cms.db;

import java.sql.SQLException;

public interface DatabaseExecutor {
	
	public void close();
	public void rollback() throws SQLException;
	public void commit() throws SQLException;
	
	public ResultObject retrieveQuery(String query, Object[] parameters) throws SQLException;
	public long retrieveSequenceValue(String sequenceName) throws SQLException;
	
	public boolean persistQuery(String query, Object[] parameters) throws SQLException;
	public long persistQueryGetLong(String query, Object[] parameters) throws SQLException;
	public String persistQueryGetString(String query, Object[] parameters) throws SQLException;
	
	/**
	 * exists
	 * description
	 * @param tableName
	 * @param columnName
	 * @param id
	 * @return boolean
	 */
	public boolean exists(String tableName, String columnName, String value) throws SQLException;
	public boolean exists(String tableName, String columnName, long id) throws SQLException;
	public boolean hasChildren(String tableName, String columnName, long id) throws SQLException;
	public boolean hasOnlyOneParent(String tableName, String columnName, long id) throws SQLException;
	
	public boolean exists(String tableName, String column1Name, String id1, String column2Name, String id2) throws SQLException;
	public boolean exists(String tableName, String column1Name, long id1, String column2Name, long id2) throws SQLException;
	
	public long countRecords(String tableName) throws SQLException;
}
