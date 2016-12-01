package com.thomsonreuters.cms.utils;

// top-level static class behavior
public final class Utils {
	
	private Utils() {
		// private default constructor
	}
	
	private static boolean equals(long value1, long value2) {
		return (value1 < value2) ? false : ((value1 > value2) ? false : true);
	}
	
	public static boolean equals(Long value1, Long value2) {
		return (value1 == null && value2 == null) ? true : ( (value1 == null || value2 == null) ? false : equals(value1.longValue(), value2.longValue()) );
	}
	
	public static boolean equals(String value1, String value2) {
		return (value1 == null && value2 == null) ? true : ( (value1 == null || value2 == null) ? false : value1.equals(value2));
	}
	
	public static String evalString(String value) {
		
		if (value != null && !value.equalsIgnoreCase("")) {
			return "\"" + value + "\"";
		} else {
			return "\"\"";
		}
	}
	
	public static String evalString(String value, String defaultValue) {
		
		if (value != null && !value.equalsIgnoreCase("")) {
			return "'" + value + "'";
		} else {
			if (defaultValue != null && !defaultValue.equalsIgnoreCase("")) {
				return "'" + defaultValue + "'";
			} else {
				return null;
			}
		}
	}
	
	public static Long evalLong(String value, String defaultValue) {
		
		if (value != null && !value.equalsIgnoreCase("")) {
			return Long.valueOf(value);
		} else {
			if(defaultValue != null && !defaultValue.equalsIgnoreCase("")) {
				return Long.valueOf(defaultValue);
			} else {
				return null;
			}
		}
	}
	
	public static Double evalDouble(String value, String defaultValue) {
		
		if (value != null && !value.equalsIgnoreCase("")) {
			return Double.valueOf(value);
		} else {
			if(defaultValue != null && !defaultValue.equalsIgnoreCase("")) {
				return Double.valueOf(defaultValue);
			} else {
				return null;
			}
		}
	}
	
	public static boolean compareValues(String value1, String value2, boolean equalsIgnoreCase) {
		
		// TODO code refactoring for this method
		if (value1 == null && value2 == null) {
			return false;
		} else if (value1 == null && value2 != null) {
			return true;
		} else if (value1 != null && value2 == null) {
			return true;
		} else {
			
			if (equalsIgnoreCase) {
				
				if (value1.equalsIgnoreCase(value2)) {
					return false;
				} else {
					return true;
				}
			} else {
				
				if (value1.equals(value2)) {
					return false;
				} else {
					return true;
				}
			}
		}
	}
}
