package com.thomsonreuters.cms.db;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.ResultSetMetaData;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.Date;
import java.util.HashMap;
import java.util.List;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

public class DatabaseExecutorOracleImpl implements DatabaseExecutor {
	
	private static final Logger logger = LoggerFactory.getLogger("DatabaseLibrary");
    
    private Connection connection;
    
    // queries
    
    private static final String sequence_QUERY = "SELECT {sequenceName}.nextval AS id FROM dual";
    
    private static final String countFor1Column_QUERY = "SELECT COUNT(*) AS numRecords FROM {tableName} WHERE upper({columnName}) = upper(?)";
    
    private static final String countFor2Columns_QUERY = "SELECT COUNT(*) AS numRecords FROM {tableName} WHERE upper({column1Name}) = upper(?) AND upper({column2Name}) = upper(?)";
    
    private static final String countRecords_QUERY = "SELECT COUNT(*) AS numRecords FROM {tableName}";
    
    public DatabaseExecutorOracleImpl(Connection connection) {
        this.connection = connection;
    }
	
	private static void closeStatement(Statement statement) {
		
        try {
            if (statement != null) {
            	statement.close();
            }
        } catch (SQLException e) {
        	logger.error("@closing Statement: {}", e.getMessage());
        }
    }
	
	private static void closeStatements(ResultSet resultSet, Statement statement) {
		
        try {
            if (resultSet != null) {
                resultSet.close();
            }
        } catch (SQLException e) {
        	logger.error("@closing ResultSet: {}", e.getMessage());
        } finally {
        	closeStatement(statement);
        }
    }
    
	@Override
    public void close() {
    	
        try {
            if (connection != null) {
            	connection.close();
            }
        } catch (SQLException e) {
        	logger.error("@closing Connection: {}", e.getMessage());
        }
    }
    
	@Override
    public void rollback() throws SQLException {
    	connection.rollback();
    }
    
	@Override
    public void commit() throws SQLException {
    	connection.commit();
    }
    
	@Override
    public ResultObject retrieveQuery(String query, Object[] parameters) throws SQLException {
    	
        PreparedStatement statement = null;
        ResultSet resultSet = null;
        
        try {
            statement = connection.prepareStatement(query);
            
            for(int i = 0; i < parameters.length; i++) {

                statement.setObject(i + 1, parameters[i]);
            }
            
            resultSet = statement.executeQuery();
            
            ResultSetMetaData resultSetMetaData = resultSet.getMetaData();
            
            HashMap<String, Integer> columnTypes = new HashMap<>();
            List<String> columnNames = new ArrayList<String>();
            
            for (int i = 1; i <= resultSetMetaData.getColumnCount(); i++) {
            	
                columnTypes.put(resultSetMetaData.getColumnName(i), resultSetMetaData.getColumnType(i));
                columnNames.add(resultSetMetaData.getColumnName(i));
            }
            
            List<RowObject> rows = new ArrayList<RowObject>();
            
            while (resultSet.next()) {
            	
                HashMap<String, Object> rowData = new HashMap<>();
                
                for (int i = 1; i <= resultSetMetaData.getColumnCount(); i++) {
                	
                    String columnName = columnNames.get(i-1);
                    
                    if(columnTypes.get(columnName) == UtilsDatabase.TIMESTAMP_WITH_TIMEZONE_TYPE) {
                        rowData.put(columnName, new Date( UtilsDatabase.getTimestamp(resultSet, i) ) );
                    } else {
                        rowData.put(columnName, resultSet.getObject(i));
                    }
                }
                rows.add(new RowObject(rowData));
            }
            
            return new ResultObject(columnTypes, rows);
            
        } catch (SQLException e) {
        	
            logger.error("Retrieve query FAILED! {}{}", e.getMessage(), query);
            throw e;
        } finally {
            closeStatements(resultSet, statement);
        }
    }
    
	@Override
    public long retrieveSequenceValue(String sequenceName) throws SQLException {
    	
        PreparedStatement statement = null;
        ResultSet resultSet = null;
        Long result = null;
        
        try {
            String query = sequence_QUERY;
            
            query = query.replace("{sequenceName}", sequenceName);
            
            statement = connection.prepareStatement(query);
            
            resultSet = statement.executeQuery();
            
            resultSet.next();
            
            result = resultSet.getLong(1);
        } catch (SQLException e ) {
        	
        	logger.error("Retrieve sequence FAILED! { {} } {}", sequenceName, e.getMessage());
            throw e;
        } finally {
            closeStatements(resultSet, statement);
        }
        return result;
    }
    
	@Override
    public boolean persistQuery(String query, Object[] parameters) throws SQLException {
    	
        PreparedStatement statement = null;
        
        try {
            statement = connection.prepareStatement(query);
            
            for(int i = 0; i < parameters.length; i++) {
            	
                statement.setObject(i + 1, parameters[i]);
            }
            
            return (statement.executeUpdate() > 0 ? true : false);
        } catch (SQLException e) {
        	
            logger.error("Persist query FAILED! {}{}", e.getMessage(), query);
            throw e;
        } finally {
            closeStatement(statement);
        }
    }
	
    private String persistQueryGetResult(String query, Object[] parameters) throws SQLException {
    	
        PreparedStatement statement = null;
        ResultSet resultSet = null;
        
        try {
            statement = connection.prepareStatement(query);
            
            for(int i = 0; i < parameters.length; i++) {
            	
                statement.setObject(i + 1, parameters[i]);
            }
            
            resultSet = statement.executeQuery();
            
            resultSet.next();
            
            return resultSet.getString(1);
        } catch (SQLException e) {
        	
            logger.error("Persist query get result FAILED! {}{}", e.getMessage(), query);
            throw e;
        } finally {
            closeStatements(resultSet, statement);
        }
    }
    
	@Override
    public long persistQueryGetLong(String query, Object[] parameters) throws SQLException {
		return Long.valueOf(persistQueryGetResult(query,parameters));
    }
	
	@Override
    public String persistQueryGetString(String query, Object[] parameters) throws SQLException {
		return persistQueryGetResult(query,parameters);
    }
    
    private long countFor1ColumnQuery(String tableName, String columnName, String id) throws SQLException {
    	
        PreparedStatement statement = null;
        ResultSet resultSet = null;
        
        String query = countFor1Column_QUERY;
        
        try {
        	query = query.replace("{tableName}", tableName);
            query = query.replace("{columnName}", columnName);
            
            statement = connection.prepareStatement(query);
            
            statement.setObject(1, id);
            
            resultSet = statement.executeQuery();
            
            resultSet.next();
            
            return resultSet.getLong(1);
        } catch (SQLException e) {
        	
            logger.error("Count query FAILED! { {}, {}, {} } {}{}", tableName, columnName, id, e.getMessage(), query);
            throw e;
        } finally {
            closeStatements(resultSet, statement);
        }
    }
    
    @Override
    public boolean exists(String tableName, String columnName, String value) throws SQLException {
    	
    	try {
    		long numRecords = countFor1ColumnQuery(tableName, columnName, value);
    		
    		return numRecords > 0 ? true : false;
    	} catch (SQLException e ) {
    		
            logger.error("Exists check FAILED!");
            throw e;
    	}
    }
    
    @Override
    public boolean exists(String tableName, String columnName, long id) throws SQLException {
    	return exists(tableName, columnName, String.valueOf(id));
    }
    
    @Override
    public boolean hasChildren(String tableName, String columnName, long id) throws SQLException {
    	
    	try {
    		long numRecords = countFor1ColumnQuery(tableName, columnName, String.valueOf(id));
    		
    		return numRecords > 0 ? true : false;
    	} catch (SQLException e ) {
    		
            logger.error("Has children records check FAILED!");
            throw e;
    	}
    }
    
    @Override
    public boolean hasOnlyOneParent(String tableName, String columnName, long id) throws SQLException {
    	
    	long numRecords;
    	
    	try {
    		numRecords = countFor1ColumnQuery(tableName, columnName, String.valueOf(id));
    		
    		return numRecords > 1 ? false : true;
    	} catch (SQLException e ) {
    		
            logger.error("Has only one parent check FAILED!");
            throw e;
    	}
    }
    
    private long countFor2ColumnsQuery(String tableName, String column1Name, String id1, String column2Name, String id2) throws SQLException {
    	
        PreparedStatement statement = null;
        ResultSet resultSet = null;
        
        String query = countFor2Columns_QUERY;
        
        try {
        	query = query.replace("{tableName}", tableName);
            query = query.replace("{column1Name}", column1Name);
            query = query.replace("{column2Name}", column2Name);
            
            statement = connection.prepareStatement(query);
            
            statement.setObject(1, id1);
            statement.setObject(2, id2);
            
            resultSet = statement.executeQuery();
            
            resultSet.next();
            
            return resultSet.getLong(1);
        } catch (SQLException e) {
        	
            logger.error("Count query FAILED! { {}, {}, {}, {}, {} } {}{}", tableName, column1Name, id1, column2Name, id2, e.getMessage(), query);
            throw e;
        } finally {
            closeStatements(resultSet, statement);
        }
    }
    
    @Override
    public boolean exists(String tableName, String column1Name, String value1, String column2Name, String value2) throws SQLException {
    	
    	try {
    		long numRecords = countFor2ColumnsQuery(tableName, column1Name, value1, column2Name, value2);
    		
    		return numRecords > 0 ? true : false;
    	} catch (SQLException e ) {
    		
            logger.error("Exists(2) check FAILED!");
            throw e;
    	}
    }
    
    @Override
    public boolean exists(String tableName, String column1Name, long id1, String column2Name, long id2) throws SQLException {
    	return exists(tableName, column1Name, String.valueOf(id1), column2Name, String.valueOf(id2));
    }
    
    @Override
    public long countRecords(String tableName) throws SQLException {
    	
        PreparedStatement statement = null;
        ResultSet resultSet = null;
        
        try {
            String query = countRecords_QUERY;
            
            query = query.replace("{tableName}", tableName);
            
            statement = connection.prepareStatement(query);
            
            resultSet = statement.executeQuery();
            
            resultSet.next();
            
            return resultSet.getLong(1);
        } catch (SQLException e ) {
        	
            logger.error("Count records FAILED! { {} } {}", tableName, e.getMessage());
            throw e;
        } finally {
            closeStatements(resultSet, statement);
        }
    }
}
