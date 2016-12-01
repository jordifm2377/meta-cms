package com.thomsonreuters.cms.db;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.Calendar;
import java.util.TimeZone;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

// top-level static class behavior
public final class UtilsDatabase {
	
	private static final Logger logger = LoggerFactory.getLogger("DatabaseLibrary");
	
	// constants
	public static final String username_QUERY = "SELECT username FROM auth_user WHERE user_id = ?";
	
	public static final int TIMESTAMP_WITH_TIMEZONE_TYPE = -101;
	public static final String SYSDATE = "SYSDATE";
	
	private static Calendar calendar;
	
	private UtilsDatabase() {
		// private default constructor
	}
	
	public static String getUsername(long userId, DatabaseExecutor databaseExecutor) throws SQLException {
    	
    	String query = username_QUERY;
    	
    	Object[] parameters = new Object[]{userId};
    	
    	String userName = databaseExecutor.persistQueryGetString(query, parameters);
    	
    	return userName;
	}
    
	public static boolean isAnExistingUser(long userId, DatabaseExecutor databaseExecutor) throws SQLException {
    	
    	return databaseExecutor.exists("auth_user", "user_id", userId);
	}
	
	public static Calendar getCalendar() {
        return calendar;
    }
	
	public static void initDBTimezoneCalendar(DatabaseExecutor databaseExecutor) {
		
		String query = "SELECT dbtimezone FROM dual";
		
		TimeZone timeZone = TimeZone.getTimeZone("GMT+00:00");
		
		try {
			ResultObject resultObject = databaseExecutor.retrieveQuery(query, new Object[]{});
			
			RowObject rowObject = resultObject.getRows().get(0);
			
			String databaseTimeZone = rowObject.getRowValue().get("DBTIMEZONE").toString();
			
			if (databaseTimeZone != null) {
				
				logger.debug("Database TimeZone: {}", databaseTimeZone);
				timeZone = TimeZone.getTimeZone("GMT" + databaseTimeZone);
			} else {
				logger.warn("Database TimeZone returned NULL");
			}
		} catch (SQLException e) {
			logger.warn("Initialization of the TimeZone Calendar FAILED! {}", e.getMessage());
		}
		
		logger.debug("Application TimeZone: " + timeZone.toString());
		calendar = Calendar.getInstance(timeZone);
	}
	
	public static Long getTimestamp(ResultSet resultSet, int columnIndex) {
		
		try {
			return resultSet.getTimestamp(columnIndex, calendar).getTime();
		} catch (SQLException e) {
			logger.warn("Timestamp: " + e.getMessage());
			return null;
		}
    }
}
