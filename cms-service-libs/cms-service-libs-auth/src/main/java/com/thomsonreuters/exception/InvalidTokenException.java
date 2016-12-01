package com.thomsonreuters.exception;

public class InvalidTokenException extends Exception {
	private static final long serialVersionUID = 2854499606014010864L;
	private  int status;
	
	public InvalidTokenException( String msg ) {
		super( msg );
	}
	
	public InvalidTokenException( String msg, int status ) {
    super( msg );
    this.status = status;
  }
	
	public InvalidTokenException( Throwable e ) {
		super( e );
	}
	
	public int getStatus() {
	  return this.status;
	}
}
