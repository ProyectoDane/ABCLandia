package com.example.abclandia;

import android.graphics.Color;
import android.graphics.drawable.GradientDrawable;
import android.os.Bundle;
import android.widget.GridView;

import com.example.abclandia.graphics.CardView;
import com.example.abclandia.graphics.JustLetterRenderer;
import com.example.abclandia.graphics.JustWordRenderer;
import com.example.abclandia.graphics.LetterWordRenderer;
import com.example.abclandia.graphics.Renderer;
import com.frba.abclandia.R;
import com.frba.abclandia.adapters.CardViewAdapter;
import com.frba.abclandia.dragdrop.DragController;
import com.frba.abclandia.dragdrop.DragLayer;
import com.frba.abclandia.stringformatter.StringWithoutLastLetter;

public class GameFiveActivity extends GameActivity {
	
	public static final int TOTAL_JOINS = 3;

	private GridView mGridViewLeft;
	private GridView mGridViewRight;

	private static String CLASS_NAME = "com.example.abclandia.GameFiveActivity";
	private static int GAME_NUMBER = 5;

	/**
	 * Called when the activity is first created.
	 */
	@Override
	public void onCreate(Bundle savedInstanceState) {

		mGameNumber = GAME_NUMBER;
		mGameClassName = CLASS_NAME;
		mTotalJoins = TOTAL_JOINS;
		super.onCreate(savedInstanceState);
		changeFirsLetter();
		
		setContentView(R.layout.game_four_five_activity);
		
		mGridViewLeft = (GridView) findViewById(R.id.gridViewLeft);
		((GradientDrawable) mGridViewLeft.getBackground()).setColor(Color.parseColor("#BDDD94"));
		mGridViewRight = (GridView) findViewById(R.id.gridViewRight);
		((GradientDrawable) mGridViewRight.getBackground()).setColor(Color.parseColor("#EDB4B0"));
		
		mGridViewLeft.setAdapter(new CardViewAdapter(data, this,
				new JustLetterRenderer(this), R.layout.game_four_five_card_view, false));
		
		Renderer justWordRenderer = new JustWordRenderer(this);
		justWordRenderer.setWordFormatter(new StringWithoutLastLetter());
		mGridViewRight.setAdapter(new CardViewAdapter(data, this,
				justWordRenderer, R.layout.game_four_five_card_view, false));

		
		mDragController = new DragController(this);
		
		mDragLayer = (DragLayer) findViewById(R.id.drag_layer);
		mDragLayer.setBackgroundColor(Color.parseColor("#EFD497"));
		mDragLayer.setDragController(mDragController);
		mDragController.setDragListener(mDragLayer);
		
		mDragLayer.setGridViewLeft(mGridViewLeft);
		mDragLayer.setGridViewRight(mGridViewRight);

		
		mAudio.loadLetterSoungs(data);
		mDroppedRenderer = new LetterWordRenderer(this);
		mDroppedRenderer.setRectangleColorBorder(Color.GREEN);

	}
	
	private void changeFirsLetter(){
		for (Card card : data){
			String word = card.getWord();
			String letter = word.substring(word.length()-1, word.length());
			 card.setLetter(letter);
		   
		}
	}
	
	protected void playCardSound(CardView cardView){
		Class<?> rendererClass = cardView.getRenderer().getClass();
		
		if (rendererClass == JustLetterRenderer.class){
			int cardId = GameDataStructure.GetLetterId(cardView.getCardLetter().toLowerCase().charAt(0));
			mAudio.playSoundLetter(cardId);
			
		} else 
			mAudio.playSoundWord(cardView.getCardId());
		
		
	}

}
