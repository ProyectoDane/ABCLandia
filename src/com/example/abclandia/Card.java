package com.example.abclandia;

public class Card {
	
	private static int UPPERCASE_LETTER = 1;
	private static int LOWERCASE_LETTER = 2;
	private static int UPPERlOWERCASE_LETTER = 3;
	
	private int mId;
	private String mWord;
	private String mLetter;
	private String mImagePath;
	
	
	
	private boolean isLowerUpperLetter = false;
		
	public Card (){
		
	}
	
	public Card (int id, String letter, String word, String imagePath, String soundWordPath, String soundLetterPath){
		mId = id;
		mLetter = letter;
		mWord = word;
		mImagePath = imagePath;
		
	}
	public Card (int id, String letter, String word, String imagePath, String soundWordPath){
		mId = id;
		mLetter = letter;
		mWord = word;
		mImagePath = imagePath;
		 
		
	}
	
	public String getLetter() {
		return mLetter;
	}
	public int getId(){
		return mId;
	}


	public String getWord() {
		return mWord;
	}
	public String getImagePath(){
		return mImagePath;
	}
	
	public boolean isEmptyCard(){
		if (mLetter == null && mWord == null){
			return true;
		}
		return false;
	}
	public boolean isLowerUpperLetter(){
		return isLowerUpperLetter;
	}
	
	//Se considera que todas las letras y palabras vienen de la BD en minuscula
	public void setLetterType(int letterType ){
		if (letterType == UPPERlOWERCASE_LETTER){
			isLowerUpperLetter = true;
			
		} else if (letterType == UPPERCASE_LETTER){
			mLetter = mLetter.toUpperCase();
			mWord = mWord.toUpperCase();
		}
	}
	
	public void setLetter(String letter){
		mLetter = letter;
	}
	
	public void setId(int id){
		mId = id;
	}
	

}
