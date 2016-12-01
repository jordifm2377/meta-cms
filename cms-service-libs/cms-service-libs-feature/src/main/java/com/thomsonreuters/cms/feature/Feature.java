package com.thomsonreuters.cms.feature;

// top-level static class behavior
public class Feature {
	
	// TODO update with the right values
	private static final long read = -1L;
	private static final long modify = -1L;
	
	public static final long get = read;
	public static final long search = read;
	
	public static final long list = read;
	
	public static final long getMedDRA = read;
	
	public static final long add = modify;
	public static final long update = modify;
	
	public static final long delete = -1L;
	
	// TODO to be moved to the tree service
	public static final long getTree = -1L;
	
	public static final long addTreeLink = -1L;
	public static final long deleteTreeLink = -1L;
	
	private Feature() {
		// private default constructor
	}
	
	public static boolean isAbleTo(String term, long feature, long userId) {
		return true; // TODO call auth-service
	}
}
