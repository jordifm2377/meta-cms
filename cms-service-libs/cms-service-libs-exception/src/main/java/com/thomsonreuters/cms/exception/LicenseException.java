package com.thomsonreuters.cms.exception;

public class LicenseException extends Exception {
	
	private static final long serialVersionUID = 1L;
	
	// tree service
	
	// TODO to be moved to the tree service
	public static final String getTree = "User has no privileges to Retrieve this tree";
	
	public static final String modifyTree = "User has no privileges to Modify this tree";
	
	// common
	
	public static final String get = "User has no privileges to Retrieve entities";
	public static final String search = "User has no privileges to Search for entities";
	
	public static final String list = "User has no privileges to List entities";
	
	public static final String medDRA = "User has no privileges to Retrieve MedDRA";
	
	public static final String add = "User has no privileges to Add entities";
	public static final String update = "User has no privileges to Update entities";
	public static final String delete = "User has no privileges to Delete entities";
	
	@SuppressWarnings("unused")
	private LicenseException() {
		// private default constructor
	}
	
	public LicenseException(String message) {
		
		super(message);
	}
}
