package com.example.abclandia;

import android.graphics.Color;
import android.graphics.drawable.GradientDrawable;
import android.os.Bundle;
import android.widget.GridView;

import com.example.abclandia.graphics.CompleteCardRenderer;
import com.example.abclandia.graphics.JustImageRenderer;
import com.example.abclandia.graphics.JustLetterRenderer;
import com.example.abclandia.graphics.JustWordRenderer;
import com.example.abclandia.graphics.LetterImageRenderer;
import com.example.abclandia.graphics.LetterWordRenderer;
import com.example.abclandia.graphics.Renderer;
import com.frba.abclandia.R;
import com.frba.abclandia.adapters.CardViewAdapter;
import com.frba.abclandia.dragdrop.DragController;
import com.frba.abclandia.dragdrop.DragLayer;
import com.frba.abclandia.stringformatter.StringWithoutdAllOccurrencesOfAnyLetter;

public class GameSixActivity extends GameActivity {
	
	public static final int TOTAL_JOINS = 6;
	
	private DragLayer mDragLayer;
	private GridView mGridViewLeft,mGridViewCenter, mGridViewRight ;
	
	private Renderer mFirstMatchRenderer;
	private static String CLASS_NAME = "com.example.abclandia.GameSixActivity";
	private static int GAME_NUMBER = 6;

	/**
     * Called when the activity is first created.
     */
    @Override
    public void onCreate(Bundle savedInstanceState) {
    	mGameNumber = GAME_NUMBER;
		mGameClassName = CLASS_NAME;
		mTotalJoins = TOTAL_JOINS;
		super.onCreate(savedInstanceState);
		
		setContentView(R.layout.game_six_activity);
        
        mDragController = new DragController (this);
      
        mDragLayer = (DragLayer) findViewById(R.id.drag_layer);
        mDragLayer.setBackgroundColor(Color.parseColor("#E6E9EE"));
        mDragLayer.setDragController (mDragController);
        mDragController.setDragListener (mDragLayer);
        mDroppedRenderer = new LetterImageRenderer(this);
        
        mAudio.loadLetterSoungs(data);
        
        mGridViewLeft = (GridView) findViewById(R.id.gridViewLeft);
        ((GradientDrawable) mGridViewLeft.getBackground()).setColor(Color.parseColor("#CCE5A8"));
        mGridViewCenter = (GridView) findViewById(R.id.gridViewCenter);
        ((GradientDrawable) mGridViewCenter.getBackground()).setColor(Color.parseColor("#F4BBB5"));
        mGridViewRight = (GridView) findViewById(R.id.gridViewRight);
        ((GradientDrawable) mGridViewRight.getBackground()).setColor(Color.parseColor("#F4DAA6"));
        
        mGridViewRight.setAdapter(new CardViewAdapter(data, this, new JustImageRenderer(this),R.layout.game_four_five_card_view, true));
        mGridViewLeft.setAdapter(new CardViewAdapter(data, this, new JustLetterRenderer(this),R.layout.game_four_five_card_view, true));
        Renderer justWordRenderer = new JustWordRenderer(this);
        justWordRenderer.setWordFormatter(new StringWithoutdAllOccurrencesOfAnyLetter());
        mGridViewCenter.setAdapter(new CardViewAdapter(data, this, justWordRenderer,R.layout.game_four_five_card_view, true));
        
        mDragLayer.setGridViewLeft(mGridViewLeft);
        mDragLayer.setGridViewCenter(mGridViewCenter);
        mDragLayer.setGridViewRight(mGridViewRight);

        mDragController.setDragListener (mDragLayer);
        mDroppedRenderer = new CompleteCardRenderer(this);
        mFirstMatchRenderer = new LetterWordRenderer(this);
        mFirstMatchRenderer.setRectangleColorBorder(Color.YELLOW);
        mDroppedRenderer.setRectangleColorBorder(Color.parseColor("#76C60E"));
        
    }

    public Renderer getMatchedRenderer(){
		return mDroppedRenderer;
	}
	
    public Renderer getFirstMatchedRenderer(){
		return mFirstMatchRenderer;
	}
	
}
