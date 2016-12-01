package com.thomsonreuters.cms.utils;

import java.util.HashMap;
import java.util.HashSet;
import java.util.Set;

// top-level static class behavior
public final class UtilsData {
	
	public static final String user_QUERY = "SELECT username FROM auth_user WHERE user_id =";
	
	private UtilsData() {
		// private default constructor
	}
	
	public static String getValue(HashMap<String, Object> rowObject, String key) {
		
		try {
			return rowObject.get(key).toString();
		} catch (NullPointerException e) {
			return null; // empty value
		}
	}
	
	private static Set<?> getSet1MinusSet2(Set<?> set1, Set<?> set2) {
		
		Set<?> set1MinusSet2 = new HashSet<>(set1);
		
		set1MinusSet2.removeAll(set2);
		
		return set1MinusSet2;
	}
	
	public static Set<?> getAddList(Set<?> newList, Set<?> currentList) {
		
		return getSet1MinusSet2(newList, currentList);
	}
	
	public static Set<?> getDelList(Set<?> newList, Set<?> currentList) {
		
		return getSet1MinusSet2(currentList, newList);
	}
}
