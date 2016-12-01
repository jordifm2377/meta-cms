package com.thomsonreuters.cms.exception;

public class AppErrorException extends Exception {
	
	private static final long serialVersionUID = 1L;
	
	// all services
	
	public static final String rollback = "FATAL ERROR -- Rollback FAILED !";
	public static final String commit = "Commit FAILED !";
	
	public static final String hierarquicalIssue = "Hierarquical issue. Hierarquical link deletion FAILED !";
	
	public static final String equalsIssue = "Equals issue. Inconsistencies found in the application code.";
	
	public static final String codeIssue = "Code issue. Inconsistencies found in the application code.";
	
	public static final String addRelatedEntities = "Adding related entities FAILED !";
	public static final String deleteRelatedEntities = "Deleting related entities FAILED !";
	
	public static final String deleteParentLink = "Delete parent link FAILED !";
	
	public static final String add = "Add entity FAILED !";
	public static final String update = "Update entity FAILED !";
	public static final String delete = "Delete entity FAILED !";
	
	// tree service
	
	public static final String missingTerm = "Missing term declaration. Inconsistencies found in the application code.";
	
	public static final String addNodeAssociation = "Associate node to a parent FAILED !";
	public static final String deleteNodeAssociation = "Disassociate node from parent FAILED !";
	
	// synchronization
	
	public static final String synchronization = "Synchronization FAILED !";
	
	@SuppressWarnings("unused")
	private AppErrorException() {
		// private default constructor
	}
	
	public AppErrorException(String message) {
		
		super(message);
	}
}
