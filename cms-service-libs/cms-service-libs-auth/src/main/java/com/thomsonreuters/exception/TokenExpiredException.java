package com.thomsonreuters.exception;


public class TokenExpiredException extends Exception {
	private static final long serialVersionUID = -5433834068346815230L;

	private final long expiration;
	private  int status;
	
	public TokenExpiredException( String msg, long expire ) {
		super( msg );
		
		this.expiration = expire;
	}
	public TokenExpiredException( String msg, long expire, int status) {
    super( msg );
    
    this.expiration = expire;
    this.status = status;
  }
	public TokenExpiredException( Throwable e, long expire ) {
		super( e );
		
		this.expiration = expire;
	}
	
	public long getExpiration() {
		return expiration;
	}
	
	public int getStatus() {
    return status;
  }
}
